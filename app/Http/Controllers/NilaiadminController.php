<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Exports\NilaiExport;
use App\Imports\NilaiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NilaiadminController extends Controller
{
    // ─────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Nilai::with(['mahasiswa', 'matakuliah']);

        // Filter kategori grade
        if ($request->filled('kategori')) {
            $query->where('nilai', strtoupper($request->kategori));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('mahasiswa', fn($q2) =>
                    $q2->where('nama', 'like', "%{$search}%")
                       ->orWhere('nim',  'like', "%{$search}%")
                )->orWhereHas('matakuliah', fn($q2) =>
                    $q2->where('nama_mk', 'like', "%{$search}%")
                       ->orWhere('kode_mk', 'like', "%{$search}%")
                )->orWhere('nilai',      'like', "%{$search}%")
                 ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $nilais = $query->latest()->paginate(15)->withQueryString();

        return view('admin.nilai.index', compact('nilais'));
    }

    // ─────────────────────────────────────────
    //  CREATE
    // ─────────────────────────────────────────
    public function create()
    {
        $mahasiswas  = Mahasiswa::orderBy('nama')->get();
        $matakuliahs = Matakuliah::orderBy('nama_mk')->get();

        return view('admin.nilai.create', compact('mahasiswas', 'matakuliahs'));
    }

    // ─────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'mahasiswa_id'  => 'required|exists:mahasiswas,id',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'semester'      => 'required|integer|between:1,8',
            'nilai'         => 'required|in:A,B,C,D,E',
            'angka'         => 'nullable|numeric|min:0|max:100',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        // Auto-isi angka jika kosong berdasarkan grade
        if (empty($data['angka'])) {
            $data['angka'] = match($data['nilai']) {
                'A' => 90, 'B' => 75, 'C' => 62, 'D' => 47, default => 30,
            };
        }

        Nilai::create($data);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────
    //  SHOW
    // ─────────────────────────────────────────
    public function show(Nilai $nilai)
    {
        $nilai->load(['mahasiswa', 'matakuliah']);

        return view('admin.nilai.detail', compact('nilai'));
    }

    // ─────────────────────────────────────────
    //  EDIT
    // ─────────────────────────────────────────
    public function edit(Nilai $nilai)
    {
        $mahasiswas  = Mahasiswa::orderBy('nama')->get();
        $matakuliahs = Matakuliah::orderBy('nama_mk')->get();

        return view('admin.nilai.edit', compact('nilai', 'mahasiswas', 'matakuliahs'));
    }

    // ─────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────
    public function update(Request $request, Nilai $nilai)
    {
        $data = $request->validate([
            'mahasiswa_id'  => 'required|exists:mahasiswas,id',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'semester'      => 'required|integer|between:1,8',
            'nilai'         => 'required|in:A,B,C,D,E',
            'angka'         => 'nullable|numeric|min:0|max:100',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        $nilai->update($data);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    // ─────────────────────────────────────────
    //  DESTROY
    // ─────────────────────────────────────────
    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    // ─────────────────────────────────────────
    //  EXPORT
    // ─────────────────────────────────────────
    public function export(Request $request)
    {
        return Excel::download(new NilaiExport($request->kategori), 'data-nilai.xlsx');
    }

    // ─────────────────────────────────────────
    //  IMPORT
    // ─────────────────────────────────────────
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        Excel::import(new NilaiImport, $request->file('file'));

        return redirect()->route('nilai.index')->with('success', 'Import nilai berhasil.');
    }
}