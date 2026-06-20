@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="row mb-3 align-items-center">

        {{-- BUTTON KIRI --}}
        <div class="col-md-6">
            <div class="d-flex gap-2">

                <button href="{{ route('mahasiswa.create') }}"
                class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="fa fa-plus"></i> Tambah Mahasiswa
                </button>

                <button href="{{ route('mahasiswa.export.excel') }}"
                class="btn btn-success d-inline-flex align-items-center gap-2">
                    <i class="fa fa-file-excel"></i> Export Excel
                </button>

                <form id="importForm"
                    action="{{ route('mahasiswa.import.excel') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="d-inline">

                    @csrf

                    <input type="file"
                        id="excelFile"
                        name="file"
                        accept=".xlsx,.xls"
                        hidden>

                    <button type="button"
                            class="btn btn-info d-inline-flex align-items-center gap-2"
                            onclick="document.getElementById('excelFile').click();">
                        <i class="fa fa-upload"></i> Import Excel
                    </button>

                </form>

            </div>
        </div>

        {{-- SEARCH KANAN --}}
        <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <div class="input-group" style="max-width:300px;">
                    <span class="input-group-text bg-white">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                    <input type="text"
                           id="searchInput"
                           class="form-control"
                           placeholder="Cari mahasiswa...">
                </div>
            </div>
        </div>

    </div>

    {{-- CARD TABLE --}}
    <div class="card shadow border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fa fa-user-graduate text-primary"></i>
                Data Mahasiswa
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="60">No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Angkatan</th>
                            <th>User</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($mahasiswas as $key => $m)
                        <tr>
                            <td>{{ $mahasiswas->firstItem() + $key }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->jk }}</td>
                            <td>{{ $m->angkatan }}</td>
                            <td>{{ $m->user->name ?? '-' }}</td>

                            <td class="text-nowrap">

                            <a href="{{ route('mahasiswa.show', $m->id) }}"
                            class="btn btn-info btn-sm">
                                Detail
                            </a>

                            <a href="{{ route('mahasiswa.edit', $m->id) }}"
                            class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('mahasiswa.destroy', $m->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus?')">
                                    Hapus
                                </button>

                            </form>

                        </td>

                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-between align-items-center mt-3">

                <small class="text-muted">
                    Menampilkan
                    {{ $mahasiswas->firstItem() }}
                    -
                    {{ $mahasiswas->lastItem() }}
                    dari
                    {{ $mahasiswas->total() }}
                    data
                </small>

                {{ $mahasiswas->links('pagination::bootstrap-5') }}

            </div>

        </div>

    </div>

</div>

@endsection

