@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Mahasiswa</h3>
        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
            + Tambah Mahasiswa
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Angkatan</th>
                        <th>User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($mahasiswas as $key => $m)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->nama }}</td>
                        <td>{{ $m->jk }}</td>
                        <td>{{ $m->angkatan }}</td>
                        <td>{{ $m->user->name ?? '-' }}</td>

                        <td>
                            <a href="{{ route('mahasiswa.edit', $m->id) }}" class="btn btn-warning btn-sm">
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
    </div>

</div>

@endsection