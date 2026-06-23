@extends('layouts.user')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-0">Nilai Akademik</h3>
            <small class="text-muted">Rekap nilai mata kuliah kamu</small>
        </div>
    </div>

    {{-- STAT --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>Total Mata Kuliah</h6>
                <h3>{{ $nilai->count() }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>Total SKS</h6>
                <h3>{{ $nilai->sum(fn($n) => $n->jadwal->mataKuliah->sks ?? 0) }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-3 text-center">
                <h6>IPK Sementara</h6>
                <h3>
                    {{ number_format($ipk ?? 0, 2) }}
                </h3>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">Daftar Nilai</h5>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Nilai</th>
                        <th>Grade</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($nilai as $key => $n)

                        @php
                            $grade = $n->nilai;

                            if ($grade >= 85) $huruf = 'A';
                            elseif ($grade >= 70) $huruf = 'B';
                            elseif ($grade >= 55) $huruf = 'C';
                            elseif ($grade >= 40) $huruf = 'D';
                            else $huruf = 'E';
                        @endphp

                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $n->jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                            <td>{{ $n->jadwal->mataKuliah->sks ?? '-' }}</td>

                            <td>
                                <span class="fw-bold">{{ $n->nilai }}</span>
                            </td>

                            <td>
                                <span class="badge
                                    @if($huruf == 'A') bg-success
                                    @elseif($huruf == 'B') bg-primary
                                    @elseif($huruf == 'C') bg-warning
                                    @elseif($huruf == 'D') bg-secondary
                                    @else bg-danger
                                    @endif
                                ">
                                    {{ $huruf }}
                                </span>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada nilai
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection