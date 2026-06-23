<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Krs;

class NilaiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            abort(403, 'Data mahasiswa tidak ditemukan');
        }

        $nilai = $mahasiswa->nilai()->with('matakuliah')->get();

        return view('user.nilai.index', compact('nilai'));
    }
}