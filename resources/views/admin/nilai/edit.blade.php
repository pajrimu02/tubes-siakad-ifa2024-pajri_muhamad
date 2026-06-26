@extends('layouts.admin')

@section('title', 'Edit Nilai')

@section('content')
<div class="page-wrapper">

    <div class="page-header">
        <div class="header-left">
             
            <div class="header-title">
                <h1>Edit Nilai</h1>
                <p>Perbarui nilai {{ $nilai->mahasiswa->nama ?? '' }}</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-grid">

                {{-- Mahasiswa --}}
                <div class="form-group full-width">
                    <label for="mahasiswa_id">Mahasiswa <span class="required">*</span></label>
                    <select id="mahasiswa_id" name="mahasiswa_id"
                            class="form-control @error('mahasiswa_id') is-invalid @enderror" required>
                        <option value="" disabled>-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswas as $m)
                            <option value="{{ $m->id }}"
                                {{ old('mahasiswa_id', $nilai->mahasiswa_id) == $m->id ? 'selected' : '' }}>
                                {{ $m->nim }} – {{ $m->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('mahasiswa_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                {{-- Mata Kuliah --}}
                <div class="form-group full-width">
                    <label for="matakuliah_id">Mata Kuliah <span class="required">*</span></label>
                    <select id="matakuliah_id" name="matakuliah_id"
                            class="form-control @error('matakuliah_id') is-invalid @enderror" required>
                        <option value="" disabled>-- Pilih Mata Kuliah --</option>
                        @foreach($matakuliahs as $mk)
                            <option value="{{ $mk->id }}"
                                {{ old('matakuliah_id', $nilai->matakuliah_id) == $mk->id ? 'selected' : '' }}>
                                {{ $mk->kode_mk }} – {{ $mk->nama_mk }} ({{ $mk->sks }} SKS)
                            </option>
                        @endforeach
                    </select>
                    @error('matakuliah_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                {{-- Semester --}}
                <div class="form-group">
                    <label for="semester">Semester <span class="required">*</span></label>
                    <select id="semester" name="semester"
                            class="form-control @error('semester') is-invalid @enderror" required>
                        <option value="" disabled>-- Pilih --</option>
                        <optgroup label="Ganjil">
                            @foreach([1,3,5,7] as $s)
                                <option value="{{ $s }}"
                                    {{ old('semester', $nilai->semester) == $s ? 'selected' : '' }}>
                                    Semester {{ $s }} (Ganjil)
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Genap">
                            @foreach([2,4,6,8] as $s)
                                <option value="{{ $s }}"
                                    {{ old('semester', $nilai->semester) == $s ? 'selected' : '' }}>
                                    Semester {{ $s }} (Genap)
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('semester')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                {{-- Grade --}}
                <div class="form-group">
                    <label for="nilai_grade">Grade <span class="required">*</span></label>
                    <select id="nilai_grade" name="nilai"
                            class="form-control @error('nilai') is-invalid @enderror" required>
                        <option value="" disabled>-- Pilih Grade --</option>
                        <option value="A" {{ old('nilai', $nilai->nilai) == 'A' ? 'selected' : '' }}>A — Sangat Baik (≥ 85)</option>
                        <option value="B" {{ old('nilai', $nilai->nilai) == 'B' ? 'selected' : '' }}>B — Baik (70–84)</option>
                        <option value="C" {{ old('nilai', $nilai->nilai) == 'C' ? 'selected' : '' }}>C — Cukup (55–69)</option>
                        <option value="D" {{ old('nilai', $nilai->nilai) == 'D' ? 'selected' : '' }}>D — Kurang (40–54)</option>
                        <option value="E" {{ old('nilai', $nilai->nilai) == 'E' ? 'selected' : '' }}>E — Tidak Lulus (&lt; 40)</option>
                    </select>
                    @error('nilai')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                {{-- Angka --}}
                <div class="form-group">
                    <label for="angka">Nilai Angka</label>
                    <input type="number" id="angka" name="angka"
                           value="{{ old('angka', $nilai->angka) }}"
                           placeholder="0 – 100" min="0" max="100" step="0.01"
                           class="form-control @error('angka') is-invalid @enderror">
                    @error('angka')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                {{-- Keterangan --}}
                <div class="form-group full-width">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan"
                           value="{{ old('keterangan', $nilai->keterangan) }}"
                           placeholder="Opsional..."
                           class="form-control @error('keterangan') is-invalid @enderror">
                    @error('keterangan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 860px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
    .page-header { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; }
    .header-left { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; font-size: .85rem; color: #6b7280; text-decoration: none; padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 8px; transition: all .15s; white-space: nowrap; }
    .btn-back:hover { background: #f3f4f6; color: #111827; }
    .header-title h1 { font-size: 1.35rem; font-weight: 700; color: #111827; margin: 0; }
    .header-title p  { font-size: .85rem; color: #6b7280; margin: 2px 0 0; }
    .alert-danger { display: flex; align-items: flex-start; gap: .75rem; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-radius: 10px; padding: .9rem 1.1rem; margin-bottom: 1.25rem; font-size: .875rem; }
    .alert-danger svg { flex-shrink: 0; margin-top: 2px; }
    .form-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 2rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem 1.5rem; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group.full-width { grid-column: 1 / -1; }
    label { font-size: .84rem; font-weight: 600; color: #374151; }
    .required { color: #ef4444; }
    .form-control { padding: .55rem .85rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: .9rem; color: #111827; background: #fff; transition: border-color .15s, box-shadow .15s; outline: none; width: 100%; box-sizing: border-box; }
    .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
    .form-control.is-invalid { border-color: #f87171; }
    select.form-control { cursor: pointer; }
    .invalid-feedback { font-size: .78rem; color: #ef4444; }
    .form-actions { display: flex; justify-content: flex-end; gap: .75rem; margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid #f3f4f6; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: .55rem 1.25rem; border-radius: 8px; font-size: .88rem; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: all .15s; }
    .btn-primary { background: #6366f1; color: #fff; }
    .btn-primary:hover { background: #4f46e5; }
    .btn-secondary { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
    .btn-secondary:hover { background: #e5e7eb; }
    @media (max-width: 600px) { .form-card { padding: 1.25rem; } .form-grid { grid-template-columns: 1fr; } .form-actions { flex-direction: column-reverse; } .btn { justify-content: center; } }
</style>
@endpush