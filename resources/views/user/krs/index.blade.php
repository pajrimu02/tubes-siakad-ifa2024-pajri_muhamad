@extends('layouts.user')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Kartu Rencana Studi (KRS)</h3>
            <small class="text-muted">Daftar mata kuliah yang kamu ambil</small>
        </div>

        <a href="{{ route('user.krs.cetak') }}" class="btn btn-primary">
            Cetak KRS
        </a>
    </div>

    {{-- STAT --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>Total KRS</h6>
                <h3>{{ $krs->count() }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>Total SKS</h6>
                <h3>{{ $krs->sum(fn($k) => $k->jadwal->mataKuliah->sks ?? 0) }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>Semester Aktif</h6>
                <h3>{{ $krs->max('semester') ?? 1 }}</h3>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">Daftar KRS</h5>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Kelas</th>
                        <th>Dosen</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($krs as $key => $k)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $k->jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                            <td>{{ $k->jadwal->mataKuliah->sks ?? '-' }}</td>
                            <td>{{ $k->semester }}</td>
                            <td>{{ $k->jadwal->kelas ?? '-' }}</td>
                            <td>{{ $k->jadwal->dosen->nama ?? '-' }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada KRS yang diambil
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection