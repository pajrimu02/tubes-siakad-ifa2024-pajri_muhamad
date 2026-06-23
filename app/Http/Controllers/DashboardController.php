<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Krs;

class DashboardController extends Controller
{
    public function index()
{
    return view('admin.dashboard', [

        // ================= BASIC DATA =================
        'mahasiswa_data'  => Mahasiswa::with('user')->get(),
        'dosen_data'      => Dosen::all(),
        'matakuliah_data' => MataKuliah::all(),
        'krs_data'        => Krs::with(['mahasiswa', 'jadwal'])->get(),

        // ================= COUNT =================
        'mahasiswa'  => Mahasiswa::count(),
        'dosen'      => Dosen::count(),
        'matakuliah' => MataKuliah::count(),
        'krs'        => Krs::count(),

        // ================= LEVEL 2 =================
        'angkatan_labels' => Mahasiswa::select('angkatan')
            ->groupBy('angkatan')
            ->orderBy('angkatan')
            ->pluck('angkatan'),

        'angkatan_data' => Mahasiswa::selectRaw('angkatan, COUNT(*) as total')
            ->groupBy('angkatan')
            ->orderBy('angkatan')
            ->pluck('total'),

        // ================= LEVEL 3 NEW =================

        // Mata kuliah paling banyak diambil
        'mk_labels' => Krs::with('jadwal.mataKuliah')
            ->get()
            ->pluck('jadwal.mataKuliah.nama_mk')
            ->filter()
            ->countBy()
            ->keys(),

        'mk_data' => Krs::with('jadwal.mataKuliah')
            ->get()
            ->pluck('jadwal.mataKuliah.nama_mk')
            ->filter()
            ->countBy()
            ->values(),

        // Top mahasiswa aktif
        'top_mahasiswa_labels' => Krs::with('mahasiswa')
            ->get()
            ->pluck('mahasiswa.nama')
            ->countBy()
            ->sortDesc()
            ->take(5)
            ->keys(),

        'top_mahasiswa_data' => Krs::with('mahasiswa')
            ->get()
            ->pluck('mahasiswa.nama')
            ->countBy()
            ->sortDesc()
            ->take(5)
            ->values(),
    ]);
}
}