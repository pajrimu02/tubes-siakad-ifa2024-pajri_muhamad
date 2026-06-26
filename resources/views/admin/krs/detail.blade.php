@extends('layouts.admin')

@section('title', 'Detail KRS')

@section('content')
<div class="page-wrapper">

    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('krs.index') }}" class="btn-back">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Kembali
            </a>
            <div class="header-title">
                <h1>Detail KRS</h1>
                <p>Informasi lengkap kartu rencana studi</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('krs.edit', $krs->id) }}" class="btn btn-edit">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit KRS
            </a>
        </div>
    </div>

    {{-- INFO CARDS ROW --}}
    <div class="info-row">

        {{-- MAHASISWA CARD --}}
        <div class="info-card">
            <div class="info-card-head">
                <div class="ic-icon" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                    <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="ic-title">Mahasiswa</span>
            </div>
            <div class="ic-body">
                <div class="avatar-lg">
                    {{ strtoupper(substr($krs->mahasiswa->nama ?? 'M', 0, 1)) }}
                </div>
                <div class="ic-name">{{ $krs->mahasiswa->nama ?? '-' }}</div>
                <div class="ic-sub">{{ $krs->mahasiswa->nim ?? '-' }}</div>
                <div class="ic-meta-row mt-2">
                    <span class="ic-tag">Angkatan {{ $krs->mahasiswa->angkatan ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- MATA KULIAH CARD --}}
        <div class="info-card">
            <div class="info-card-head">
                <div class="ic-icon" style="background:linear-gradient(135deg,#0ea5e9,#0284c7);">
                    <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
                    </svg>
                </div>
                <span class="ic-title">Mata Kuliah</span>
            </div>
            <div class="ic-body">
                <div class="ic-name">{{ $krs->jadwal->mataKuliah->nama_mk ?? '-' }}</div>
                <div class="ic-sub">{{ $krs->jadwal->mataKuliah->kode_mk ?? '-' }}</div>
                <div class="ic-meta-row mt-2">
                    <span class="ic-tag">{{ $krs->jadwal->mataKuliah->sks ?? '-' }} SKS</span>
                </div>
            </div>
        </div>

        {{-- JADWAL CARD --}}
        <div class="info-card">
            <div class="info-card-head">
                <div class="ic-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                    <svg width="18" height="18" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <span class="ic-title">Jadwal</span>
            </div>
            <div class="ic-body">
                <div class="ic-name">{{ $krs->jadwal->hari ?? '-' }}</div>
                <div class="ic-sub">
                    {{ $krs->jadwal->jam_mulai ?? '' }} – {{ $krs->jadwal->jam_selesai ?? '' }}
                </div>
                <div class="ic-meta-row mt-2">
                    <span class="ic-tag">Ruang {{ $krs->jadwal->ruangan ?? '-' }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- DETAIL TABLE --}}
    <div class="detail-card">
        <div class="detail-head">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>
            </svg>
            Informasi KRS
        </div>
        <table class="detail-table">
            <tr>
                <td class="dt-label">Dosen Pengampu</td>
                <td class="dt-val">{{ $krs->jadwal->dosen->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="dt-label">Semester</td>
                <td class="dt-val">
                    @php $smt = $krs->semester ?? 0; @endphp
                    Semester {{ $smt }}
                    @if(in_array($smt, [1,3,5,7]))
                        <span class="badge-ganjil ms-1">Ganjil</span>
                    @else
                        <span class="badge-genap ms-1">Genap</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="dt-label">Tahun Akademik</td>
                <td class="dt-val"><span class="badge-tahun">{{ $krs->tahun_akademik ?? '-' }}</span></td>
            </tr>
            <tr>
                <td class="dt-label">Dibuat</td>
                <td class="dt-val">{{ $krs->created_at?->format('d M Y, H:i') ?? '-' }}</td>
            </tr>
            <tr>
                <td class="dt-label">Diperbarui</td>
                <td class="dt-val">{{ $krs->updated_at?->format('d M Y, H:i') ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- DANGER ZONE --}}
    <div class="danger-zone">
        <div class="dz-label">Hapus KRS</div>
        <p class="dz-desc">Tindakan ini tidak dapat dibatalkan. KRS akan dihapus permanen.</p>
        <form action="{{ route('krs.destroy', $krs->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger-del"
                    onclick="return confirm('Yakin ingin menghapus KRS ini secara permanen?')">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                    <path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
                Hapus KRS Ini
            </button>
        </form>
    </div>

</div>
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 900px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
    .page-header  { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 1.75rem; flex-wrap: wrap; }
    .header-left  { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; font-size: .85rem; color: #6b7280; text-decoration: none; padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 8px; transition: all .15s; }
    .btn-back:hover { background: #f3f4f6; color: #111827; }
    .header-title h1 { font-size: 1.3rem; font-weight: 700; color: #111827; margin: 0; }
    .header-title p  { font-size: .85rem; color: #6b7280; margin: 2px 0 0; }
    .btn.btn-edit { display: inline-flex; align-items: center; gap: 6px; padding: .5rem 1.1rem; border-radius: 9px; font-size: .85rem; font-weight: 600; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; text-decoration: none; transition: all .15s; }
    .btn.btn-edit:hover { background: #fde68a; }

    /* INFO ROW */
    .info-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.1rem; margin-bottom: 1.25rem; }
    .info-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; padding: 1.25rem; box-shadow: 0 1px 4px rgba(0,0,0,.05); }
    .info-card-head { display: flex; align-items: center; gap: .6rem; margin-bottom: 1rem; }
    .ic-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ic-title { font-size: .78rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .05em; }
    .ic-body { text-align: center; }
    .avatar-lg { width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg,#6366f1,#4f46e5); color: #fff; font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; justify-content: center; margin: 0 auto .6rem; }
    .ic-name { font-size: .95rem; font-weight: 700; color: #1e293b; }
    .ic-sub  { font-size: .8rem; color: #94a3b8; margin-top: 2px; }
    .ic-meta-row { display: flex; justify-content: center; gap: .4rem; flex-wrap: wrap; }
    .ic-tag { background: #f1f5f9; color: #475569; font-size: .75rem; font-weight: 600; padding: 2px 9px; border-radius: 999px; }

    /* DETAIL CARD */
    .detail-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.05); margin-bottom: 1.25rem; }
    .detail-head { display: flex; align-items: center; gap: 8px; font-size: .88rem; font-weight: 700; color: #374151; background: #f8fafc; padding: .9rem 1.25rem; border-bottom: 1px solid #e5e7eb; }
    .detail-table { width: 100%; border-collapse: collapse; }
    .detail-table tr:not(:last-child) td { border-bottom: 1px solid #f1f5f9; }
    .dt-label { padding: .8rem 1.25rem; font-size: .83rem; font-weight: 600; color: #94a3b8; width: 200px; white-space: nowrap; }
    .dt-val   { padding: .8rem 1.25rem; font-size: .88rem; color: #1e293b; font-weight: 500; }
    .badge-ganjil { display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 999px; font-size: .73rem; font-weight: 600; background: #ede9fe; color: #5b21b6; }
    .badge-genap  { display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 999px; font-size: .73rem; font-weight: 600; background: #dcfce7; color: #166534; }
    .badge-tahun  { display: inline-flex; align-items: center; padding: 2px 9px; border-radius: 999px; font-size: .73rem; font-weight: 600; background: #e0f2fe; color: #0369a1; }

    /* DANGER ZONE */
    .danger-zone { background: #fff; border: 1px solid #fecaca; border-radius: 14px; padding: 1.25rem 1.5rem; }
    .dz-label { font-size: .88rem; font-weight: 700; color: #b91c1c; margin-bottom: 4px; }
    .dz-desc  { font-size: .82rem; color: #6b7280; margin-bottom: .9rem; }
    .btn-danger-del { display: inline-flex; align-items: center; gap: 6px; padding: .5rem 1.1rem; border-radius: 9px; font-size: .85rem; font-weight: 600; background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; cursor: pointer; transition: all .15s; }
    .btn-danger-del:hover { background: #fecaca; }

    @media(max-width:700px){ .info-row { grid-template-columns: 1fr; } }
</style>
@endpush