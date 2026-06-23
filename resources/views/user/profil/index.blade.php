@extends('layouts.user')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Profil Mahasiswa</h3>
            <small class="text-muted">Informasi data diri akun kamu</small>
        </div>
    </div>

    {{-- PROFILE CARD --}}
    <div class="row">

        {{-- LEFT PROFILE --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4">

                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&size=120"
                     class="rounded-circle mx-auto mb-3"
                     width="120" height="120">

                <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                <small class="text-muted">{{ auth()->user()->email }}</small>

                <hr>

                <span class="badge bg-success">
                    Mahasiswa Aktif
                </span>

            </div>
        </div>

        {{-- RIGHT DETAIL --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 p-3">

                <h5 class="mb-3">Data Lengkap</h5>

                @php
                    $mhs = auth()->user()->mahasiswa;
                @endphp

                @if($mhs)

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="text-muted">NIM</label>
                            <div class="fw-bold">{{ $mhs->nim }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Nama</label>
                            <div class="fw-bold">{{ $mhs->nama }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Jenis Kelamin</label>
                            <div class="fw-bold">
                                {{ $mhs->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">No HP</label>
                            <div class="fw-bold">{{ $mhs->no_hp }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Angkatan</label>
                            <div class="fw-bold">{{ $mhs->angkatan }}</div>
                        </div>

                        <div class="col-md-12">
                            <label class="text-muted">Alamat</label>
                            <div class="fw-bold">{{ $mhs->alamat }}</div>
                        </div>

                    </div>

                    <div class="mt-4">
                        <a href="{{ route('user.profil.edit') }}" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Edit Profil
                        </a>
                    </div>

                @else

                    <div class="alert alert-danger">
                        Data mahasiswa tidak ditemukan. Hubungi admin.
                    </div>

                @endif

            </div>
        </div>

    </div>
</div>

@endsection