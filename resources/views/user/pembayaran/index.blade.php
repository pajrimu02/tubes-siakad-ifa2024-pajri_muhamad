@extends('layouts.user')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3>Pembayaran Kuliah</h3>
        <small class="text-muted">
            Status pembayaran mahasiswa
        </small>
    </div>

    {{-- CARD SUMMARY --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6>Total Tagihan</h6>
                    <h4 class="text-primary">
                        Rp {{ number_format(5000000, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6>Sudah Dibayar</h6>
                    <h4 class="text-success">
                        Rp {{ number_format(2500000, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6>Sisa Tagihan</h6>
                    <h4 class="text-danger">
                        Rp {{ number_format(2500000, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">Riwayat Pembayaran</h5>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Semester</th>
                        <th>Tagihan</th>
                        <th>Status</th>
                        <th>Tanggal Bayar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pembayaran as $p)
                        <tr>
                            <td>{{ $p->semester }}</td>
                            <td>Rp {{ number_format($p->tagihan, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status == 'Lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </td>
                            <td>{{ $p->tanggal ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection