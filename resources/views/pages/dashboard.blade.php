@extends('layouts.admin')

@section('content')

<h3 class="mb-4">Dashboard SIAKAD</h3>

<div class="row">

    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5>Mahasiswa</h5>
                <h3>{{ \App\Models\Mahasiswa::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5>Dosen</h5>
                <h3>{{ \App\Models\Dosen::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5>Mata Kuliah</h5>
                <h3>{{ \App\Models\MataKuliah::count() }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5>KRS</h5>
                <h3>{{ \App\Models\Krs::count() }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection