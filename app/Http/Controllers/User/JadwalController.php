<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with(['mataKuliah', 'dosen'])
            ->whereHas('krs', function ($q) {
                $q->where('mahasiswa_id', auth()->user()->mahasiswa->id);
            })
            ->get();

        return view('user.jadwal.index', compact('jadwal'));
    }
}