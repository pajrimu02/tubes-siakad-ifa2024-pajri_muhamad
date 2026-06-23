<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        return view('user.profil.index');
    }

    public function edit()
    {
        return view('user.profil.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $mhs = $user->mahasiswa;

        if (!$mhs) {
            abort(403, 'Data mahasiswa tidak ditemukan');
        }

        $mhs->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'jk' => $request->jk,
            'angkatan' => $request->angkatan,
            'alamat' => $request->alamat,
        ]);

        return redirect()
            ->route('user.profil.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}