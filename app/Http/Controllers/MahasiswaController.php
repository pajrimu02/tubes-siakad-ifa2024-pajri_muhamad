<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
        {
            $mahasiswas = Mahasiswa::with('user')
                            ->latest()
                            ->paginate(15);

            return view('mahasiswa.index', compact('mahasiswas'));
        }

    public function create()
    {
        $users = User::all();
        return view('mahasiswa.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'nama' => 'required',
            'jk' => 'required',
            'angkatan' => 'required',
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $users = User::all();

        return view('mahasiswa.edit', compact('mahasiswa', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'nim' => 'required',
            'nama' => 'required',
            'jk' => 'required',
            'angkatan' => 'required',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update($request->all());

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil diupdate');
    }

    public function destroy($id)
    {
        Mahasiswa::destroy($id);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus');
    }
}