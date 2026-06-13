@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Dosen</h3>
        <a href="{{ route('dosen.create') }}" class="btn btn-primary">
            + Tambah Dosen
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIDN</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($dosens as $key => $d)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $d->nidn }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->email }}</td>
                        <td>{{ $d->no_hp }}</td>

                        <td>
                            <a href="{{ route('dosen.edit', $d->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('dosen.destroy', $d->id) }}"
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