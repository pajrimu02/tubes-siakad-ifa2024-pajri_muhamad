<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
        public function index()
    {
        $user = auth()->user();

        $mahasiswa = $user->mahasiswa;

        $krs = Krs::with(['jadwal.mataKuliah'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();

        return view('user.dashboard', compact('krs'));
    }
}