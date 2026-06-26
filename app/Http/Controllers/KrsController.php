<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Exports\KrsExport;
use App\Imports\KrsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KrsController extends Controller
{
    // ─────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Krs::with([
            'mahasiswa',
            'jadwal.dosen',
            'jadwal.mataKuliah',
        ]);

        // Filter ganjil / genap
        if ($request->filled('tipe')) {
            if ($request->tipe === 'ganjil') {
                $query->whereIn('semester', [1, 3, 5, 7]);
            } elseif ($request->tipe === 'genap') {
                $query->whereIn('semester', [2, 4, 6, 8]);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('mahasiswa', fn($q2) =>
                    $q2->where('nama', 'like', "%{$search}%")
                       ->orWhere('nim', 'like', "%{$search}%")
                )->orWhereHas('jadwal.mataKuliah', fn($q2) =>
                    $q2->where('nama_mk', 'like', "%{$search}%")
                       ->orWhere('kode_mk', 'like', "%{$search}%")
                )->orWhereHas('jadwal.dosen', fn($q2) =>
                    $q2->where('nama', 'like', "%{$search}%")
                );
            });
        }

        $krs = $query->latest()->paginate(15)->withQueryString();

        return view('admin.krs.index', compact('krs'));
    }

    // ─────────────────────────────────────────
    //  CREATE
    // ─────────────────────────────────────────
    public function create()
    {
        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        $jadwals    = Jadwal::with(['mataKuliah', 'dosen'])->get();

        return view('admin.krs.create', compact('mahasiswas', 'jadwals'));
    }

    // ─────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'mahasiswa_id'   => 'required|exists:mahasiswas,id',
            'jadwal_id'      => 'required|exists:jadwals,id',
            'semester'       => 'required|integer|between:1,8',
            'tahun_akademik' => 'required|string|max:20',
        ]);

        $exists = Krs::where('mahasiswa_id', $data['mahasiswa_id'])
                     ->where('jadwal_id', $data['jadwal_id'])
                     ->where('tahun_akademik', $data['tahun_akademik'])
                     ->exists();

        if ($exists) {
            return back()
                ->withErrors(['jadwal_id' => 'Mahasiswa sudah mengambil jadwal ini di tahun akademik yang sama.'])
                ->withInput();
        }

        Krs::create($data);

        return redirect()->route('krs.index')->with('success', 'KRS berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────
    //  SHOW  — parameter $krs harus cocok dengan {krs} di route
    // ─────────────────────────────────────────
    public function show(Krs $krs)
    {
        $krs->load(['mahasiswa.user', 'jadwal.mataKuliah', 'jadwal.dosen']);

        return view('admin.krs.detail', compact('krs'));
    }

    // ─────────────────────────────────────────
    //  EDIT  — parameter $krs harus cocok dengan {krs} di route
    // ─────────────────────────────────────────
    public function edit(Krs $krs)
    {
        $mahasiswas = Mahasiswa::orderBy('nama')->get();
        $jadwals    = Jadwal::with(['mataKuliah', 'dosen'])->get();

        return view('admin.krs.edit', compact('krs', 'mahasiswas', 'jadwals'));
    }

    // ─────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────
    public function update(Request $request, Krs $krs)
    {
        $data = $request->validate([
            'mahasiswa_id'   => 'required|exists:mahasiswas,id',
            'jadwal_id'      => 'required|exists:jadwals,id',
            'semester'       => 'required|integer|between:1,8',
            'tahun_akademik' => 'required|string|max:20',
        ]);

        $krs->update($data);

        return redirect()->route('krs.index')->with('success', 'KRS berhasil diperbarui.');
    }

    // ─────────────────────────────────────────
    //  DESTROY
    // ─────────────────────────────────────────
    public function destroy(Krs $krs)
    {
        $krs->delete();

        return redirect()->route('krs.index')->with('success', 'KRS berhasil dihapus.');
    }

    // ─────────────────────────────────────────
    //  EXPORT
    // ─────────────────────────────────────────
    public function export(Request $request)
    {
        return Excel::download(new KrsExport($request->tipe), 'data-krs.xlsx');
    }

    // ─────────────────────────────────────────
    //  IMPORT
    // ─────────────────────────────────────────
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new KrsImport, $request->file('file'));

        return redirect()->route('krs.index')->with('success', 'Import KRS berhasil.');
    }
}