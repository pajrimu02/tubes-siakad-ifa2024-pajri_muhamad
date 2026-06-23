<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Support\Facades\Auth;

class KrsController extends Controller
{
    public function index()
    {
        $krs = Krs::with(['jadwal.mataKuliah', 'jadwal.dosen'])
            ->where('mahasiswa_id', auth()->user()->mahasiswa->id)
            ->get();

        return view('user.krs.index', compact('krs'));
    }

    public function cetak()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            abort(403, 'Data mahasiswa tidak ditemukan');
        }

        $krs = Krs::with(['jadwal.mataKuliah'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        return view('user.krs.cetak', compact('krs', 'mahasiswa'));
    }
}