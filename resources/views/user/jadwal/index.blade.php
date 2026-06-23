@extends('layouts.user')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Jadwal Kuliah</h3>
            <small class="text-muted">Daftar jadwal perkuliahan kamu</small>
        </div>
    </div>

    {{-- SUMMARY CARD --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>Total Jadwal</h6>
                <h3>{{ $jadwal->count() }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>Mata Kuliah</h6>
                <h3>{{ $jadwal->unique('mata_kuliah_id')->count() }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>Dosen Pengajar</h6>
                <h3>{{ $jadwal->unique('dosen_id')->count() }}</h3>
            </div>
        </div>

    </div>

    {{-- TABLE JADWAL --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">Detail Jadwal Kuliah</h5>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Kelas</th>
                        <th>Dosen</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($jadwal as $key => $j)

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <span class="badge bg-primary">
                                    {{ $j->hari }}
                                </span>
                            </td>
                            <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                            <td>{{ $j->mataKuliah->nama_mk ?? '-' }}</td>
                            <td>{{ $j->mataKuliah->sks ?? '-' }}</td>
                            <td>{{ $j->kelas }}</td>
                            <td>{{ $j->dosen->nama ?? '-' }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada jadwal kuliah
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection