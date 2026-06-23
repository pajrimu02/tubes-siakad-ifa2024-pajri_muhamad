@extends('layouts.user')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h3 class="mb-0">Edit Profil</h3>
        <small class="text-muted">Perbarui data diri kamu</small>
    </div>

    <div class="card shadow-sm border-0 p-4">

        @php
            $mhs = auth()->user()->mahasiswa;
        @endphp

        @if($mhs)

        <form action="{{ route('user.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label>NIM</label>
                    <input type="text" class="form-control" value="{{ $mhs->nim }}" disabled>
                </div>

                <div class="col-md-6">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $mhs->nama }}">
                </div>

                <div class="col-md-6">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $mhs->no_hp }}">
                </div>

                <div class="col-md-6">
                    <label>Jenis Kelamin</label>
                    <select name="jk" class="form-control">
                        <option value="L" {{ $mhs->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $mhs->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Angkatan</label>
                    <input type="number" name="angkatan" class="form-control" value="{{ $mhs->angkatan }}">
                </div>

                <div class="col-md-12">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control">{{ $mhs->alamat }}</textarea>
                </div>

            </div>

            <div class="mt-4">
                <button class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('user.profil.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>

        @else
            <div class="alert alert-danger">
                Data mahasiswa tidak ditemukan
            </div>
        @endif

    </div>
</div>

@endsection