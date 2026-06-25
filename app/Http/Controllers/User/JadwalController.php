<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;

class JadwalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 🔥 SAFE CHECK
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            abort(403, 'Akun ini belum terhubung dengan data mahasiswa');
        }

        $jadwal = Jadwal::with(['mataKuliah', 'dosen'])
            ->whereHas('krs', function ($q) use ($mahasiswa) {
                $q->where('mahasiswa_id', $mahasiswa->id);
            })
            ->get();

        return view('user.jadwal.index', compact('jadwal'));
    }
}