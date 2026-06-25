@extends('layouts.user')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

.edit-wrap * {
    font-family: 'Inter', sans-serif;
    box-sizing: border-box;
}

/* HEADER */
.edit-header h3 {
    font-size: 20px;
    font-weight: 800;
    color: #111827;
}
.edit-header small {
    font-size: 13px;
    color: #6b7280;
}

/* CARD */
.edit-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
    transition: 0.25s ease;
    animation: fadeUp 0.5s ease;
}
.edit-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

/* SECTION HEADER */
.card-section-header {
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 10px;
}
.sec-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #ede9fe;
    color: #6366f1;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card-section-header h5 {
    font-size: 14px;
    font-weight: 700;
    margin: 0;
}
.card-section-header small {
    font-size: 12px;
    color: #9ca3af;
}

/* FORM GRID */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1px;
    background: #f1f5f9;
}

.form-item {
    background: #fff;
    padding: 16px 22px;
    position: relative;
}

.form-item label {
    font-size: 11px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    margin-bottom: 6px;
    display: block;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    padding: 10px 12px;
    font-size: 14px;
    transition: 0.2s;
}

.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
    outline: none;
}

/* FULL WIDTH */
.full {
    grid-column: 1 / -1;
}

/* BUTTON */
.btn-save {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 20px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    box-shadow: 0 3px 12px rgba(99,102,241,0.3);
    transition: 0.2s;
}
.btn-save:hover {
    transform: translateY(-2px);
}

/* BACK BUTTON */
.btn-back {
    padding: 11px 18px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #374151;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
}
.btn-back:hover {
    background: #f9fafb;
}

/* ANIMATION */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="container-fluid edit-wrap">

    {{-- HEADER --}}
    <div class="mb-4 edit-header">
        <h3>Edit Profil</h3>
        <small>Perbarui data diri kamu</small>
    </div>

    @php
        $mhs = auth()->user()->mahasiswa;
    @endphp

    <div class="edit-card">

        <div class="card-section-header">
            <div class="sec-icon">
                <i class="fa-solid fa-user-pen"></i>
            </div>
            <div>
                <h5>Form Edit Profil</h5>
                <small>Data akan tersimpan di sistem SIAKAD</small>
            </div>
        </div>

        @if($mhs)

        <form action="{{ route('user.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-item">
                    <label>NIM</label>
                    <input type="text" class="form-control" value="{{ $mhs->nim }}" disabled>
                </div>

                <div class="form-item">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $mhs->nama }}">
                </div>

                <div class="form-item">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $mhs->no_hp }}">
                </div>

                <div class="form-item">
                    <label>Jenis Kelamin</label>
                    <select name="jk" class="form-control">
                        <option value="L" {{ $mhs->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $mhs->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="form-item">
                    <label>Angkatan</label>
                    <input type="number" name="angkatan" class="form-control" value="{{ $mhs->angkatan }}">
                </div>

                <div class="form-item full">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control">{{ $mhs->alamat }}</textarea>
                </div>

            </div>

            <div class="d-flex justify-content-between p-4 border-top">
                <a href="{{ route('user.profil.index') }}" class="btn-back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>

                <button class="btn-save">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>

        @else
            <div class="p-4">
                <div class="alert alert-danger">
                    Data mahasiswa tidak ditemukan
                </div>
            </div>
        @endif

    </div>
</div>

@endsection