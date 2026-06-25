<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MahasiswaExport;
use App\Imports\MahasiswaImport;

class MahasiswaController extends Controller
{
    /**
     * Tampilkan daftar mahasiswa dengan pencarian & filter angkatan.
     */
    public function index(Request $request)
    {
        $mahasiswas = Mahasiswa::with(['user', 'krs.jadwal.mataKuliah'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            })
            ->when($request->angkatan, function ($q) use ($request) {
                $q->where('angkatan', $request->angkatan);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString(); // biar filter & search tetap saat pindah halaman

        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    /**
     * Form tambah mahasiswa.
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    /**
     * Simpan mahasiswa baru. User dibuat otomatis.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim'      => 'required|unique:mahasiswas,nim',
            'nama'     => 'required|string|max:255',
            'jk'       => 'required|in:L,P',
            'alamat'   => 'nullable|string',
            'no_hp'    => 'nullable|string|max:20',
            'angkatan' => 'required|digits:4',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->nama,
                'email'    => $request->nim . '@mahasiswa.ac.id',
                'password' => Hash::make($request->nim),
            ]);

            $user->assignRole('mahasiswa');

            Mahasiswa::create([
                'user_id'  => $user->id,
                'nim'      => $request->nim,
                'nama'     => $request->nama,
                'jk'       => $request->jk,
                'alamat'   => $request->alamat,
                'no_hp'    => $request->no_hp,
                'angkatan' => $request->angkatan,
            ]);
        });

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan. Login: ' . $request->nim . '@mahasiswa.ac.id | Password: NIM');
    }

    /**
     * Detail mahasiswa. Semester dari KRS → MataKuliah.
     */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::with([
            'user',
            'krs.jadwal.mataKuliah',
            'nilai.matakuliah',
            'pembayaran',
        ])->findOrFail($id);

        $semesterAktif = $mahasiswa->krs
            ->map(fn($krs) => optional(optional($krs->jadwal)->mataKuliah)->semester)
            ->filter()->unique()->sort()->values();

        return view('admin.mahasiswa.detail', compact('mahasiswa', 'semesterAktif'));
    }

    /**
     * Form edit mahasiswa.
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    /**
     * Update mahasiswa. Sinkron user terkait.
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $request->validate([
            'nim'      => 'required|unique:mahasiswas,nim,' . $id,
            'nama'     => 'required|string|max:255',
            'jk'       => 'required|in:L,P',
            'alamat'   => 'nullable|string',
            'no_hp'    => 'nullable|string|max:20',
            'angkatan' => 'required|digits:4',
        ]);

        DB::transaction(function () use ($request, $mahasiswa) {
            if ($mahasiswa->user) {
                $mahasiswa->user->update([
                    'name'  => $request->nama,
                    'email' => $request->nim . '@mahasiswa.ac.id',
                ]);
            }

            $mahasiswa->update([
                'nim'      => $request->nim,
                'nama'     => $request->nama,
                'jk'       => $request->jk,
                'alamat'   => $request->alamat,
                'no_hp'    => $request->no_hp,
                'angkatan' => $request->angkatan,
            ]);
        });

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Hapus mahasiswa beserta user-nya.
     */
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);

        DB::transaction(function () use ($mahasiswa) {
            if ($mahasiswa->user) {
                $mahasiswa->user->delete();
            }
            $mahasiswa->delete();
        });

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }

    // ────────────────────────────────────────────
    // EXPORT
    // ────────────────────────────────────────────

    /**
     * Export semua mahasiswa ke Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new MahasiswaExport, 'mahasiswa_' . date('Ymd_His') . '.xlsx');
    }

    // ────────────────────────────────────────────
    // IMPORT
    // ────────────────────────────────────────────

    /**
     * Import mahasiswa dari file Excel.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:5120',
        ]);

        try {
            Excel::import(new MahasiswaImport, $request->file('file'));
            return redirect()->route('mahasiswa.index')
                ->with('success', 'Import mahasiswa berhasil.');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.index')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}