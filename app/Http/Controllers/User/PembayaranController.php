<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function index()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            abort(403, 'Data mahasiswa tidak ditemukan');
        }

        $pembayaran = Pembayaran::where('mahasiswa_id', $mahasiswa->id)->get();

        return view('user.pembayaran.index', compact('pembayaran'));
    }
}