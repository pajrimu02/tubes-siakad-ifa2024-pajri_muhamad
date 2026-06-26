<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalExport;
use App\Imports\JadwalImport;

class JadwalController extends Controller
{
    const HARI   = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const KELAS  = ['A','B','C','D','E','F'];

    /**
     * Daftar jadwal dengan search + filter kelas.
     */
    public function index(Request $request)
    {
        $jadwal = Jadwal::with(['mataKuliah', 'dosen'])
            ->when($request->search, function ($q) use ($request) {
                $q->whereHas('mataKuliah', fn($q) =>
                        $q->where('nama_mk', 'like', '%'.$request->search.'%')
                          ->orWhere('kode_mk', 'like', '%'.$request->search.'%')
                    )
                    ->orWhereHas('dosen', fn($q) =>
                        $q->where('nama', 'like', '%'.$request->search.'%')
                    )
                    ->orWhere('hari', 'like', '%'.$request->search.'%')
                    ->orWhere('ruangan', 'like', '%'.$request->search.'%');
            })
            ->when($request->kelas, fn($q) => $q->where('kelas', $request->kelas))
            ->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->paginate(15)
            ->withQueryString();

        return view('admin.jadwal.index', compact('jadwal'));
    }

    /**
     * Form tambah jadwal.
     */
    public function create()
    {
        $dosens      = Dosen::orderBy('nama')->get();
        $matakuliahs = MataKuliah::orderBy('semester')->orderBy('nama_mk')->get();
        $hari        = self::HARI;
        $kelas       = self::KELAS;

        return view('admin.jadwal.create', compact('dosens', 'matakuliahs', 'hari', 'kelas'));
    }

    /**
     * Simpan jadwal baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dosen_id'       => 'required|exists:dosens,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'hari'           => 'required|in:'.implode(',', self::HARI),
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'kelas'          => 'required|in:'.implode(',', self::KELAS),
            'ruangan'        => 'required|string|max:50',
        ]);

        Jadwal::create($request->only(
            'dosen_id','mata_kuliah_id','hari','jam_mulai','jam_selesai','kelas','ruangan'
        ));

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Detail jadwal.
     */
    public function show($id)
    {
        $jadwal = Jadwal::with(['mataKuliah', 'dosen', 'krs.mahasiswa'])
            ->findOrFail($id);

        return view('admin.jadwal.detail', compact('jadwal'));
    }

    /**
     * Form edit jadwal.
     */
    public function edit($id)
    {
        $jadwal      = Jadwal::findOrFail($id);
        $dosens      = Dosen::orderBy('nama')->get();
        $matakuliahs = MataKuliah::orderBy('semester')->orderBy('nama_mk')->get();
        $hari        = self::HARI;
        $kelas       = self::KELAS;

        return view('admin.jadwal.edit', compact('jadwal', 'dosens', 'matakuliahs', 'hari', 'kelas'));
    }

    /**
     * Update jadwal.
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'dosen_id'       => 'required|exists:dosens,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'hari'           => 'required|in:'.implode(',', self::HARI),
            'jam_mulai'      => 'required',
            'jam_selesai'    => 'required|after:jam_mulai',
            'kelas'          => 'required|in:'.implode(',', self::KELAS),
            'ruangan'        => 'required|string|max:50',
        ]);

        $jadwal->update($request->only(
            'dosen_id','mata_kuliah_id','hari','jam_mulai','jam_selesai','kelas','ruangan'
        ));

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Hapus jadwal.
     */
    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Export jadwal ke Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new JadwalExport, 'jadwal_' . date('Ymd_His') . '.xlsx');
    }

    /**
     * Import jadwal dari Excel.
     */
    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls|max:5120']);

        try {
            Excel::import(new JadwalImport, $request->file('file'));
            return redirect()->route('jadwal.index')
                ->with('success', 'Import jadwal berhasil.');
        } catch (\Exception $e) {
            return redirect()->route('jadwal.index')
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}