{{-- resources/views/admin/mahasiswa/detail.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="page-wrapper">

    {{-- ── Header ── --}}
    <div class="page-header">
        <a href="{{ route('mahasiswa.index') }}" class="btn-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Kembali
        </a>
        <div class="header-info">
            <h1>Detail Mahasiswa</h1>
            <p>Data lengkap, KRS, nilai, dan pembayaran</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-warning">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <form action="{{ route('mahasiswa.destroy', $mahasiswa->id) }}" method="POST"
                  onsubmit="return confirm('Hapus mahasiswa ini beserta akun login-nya?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6M14 11v6"/>
                        <path d="M9 6V4h6v2"/>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- ── Profil Card ── --}}
    <div class="profile-card">
        <div class="profile-avatar">
            {{ strtoupper(substr($mahasiswa->nama, 0, 2)) }}
        </div>
        <div class="profile-main">
            <h2>{{ $mahasiswa->nama }}</h2>
            <span class="nim-badge">{{ $mahasiswa->nim }}</span>
            <div class="profile-meta">
                <span>
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    {{ $mahasiswa->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
                <span>
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Angkatan {{ $mahasiswa->angkatan }}
                </span>
                @if($semesterAktif->isNotEmpty())
                <span class="smt-aktif">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
                    </svg>
                    Semester {{ $semesterAktif->implode(', ') }}
                </span>
                @endif
            </div>
        </div>
        <div class="profile-stats">
            <div class="stat">
                <span class="stat-val">{{ $mahasiswa->krs->count() }}</span>
                <span class="stat-lbl">Mata Kuliah</span>
            </div>
            <div class="stat">
                <span class="stat-val">{{ $mahasiswa->nilai->count() }}</span>
                <span class="stat-lbl">Nilai</span>
            </div>
            <div class="stat">
                @php
                    $lunas = $mahasiswa->pembayaran->where('status', 'lunas')->count();
                @endphp
                <span class="stat-val {{ $lunas > 0 ? 'text-success' : 'text-danger' }}">
                    {{ $lunas > 0 ? 'Lunas' : 'Belum' }}
                </span>
                <span class="stat-lbl">Pembayaran</span>
            </div>
        </div>
    </div>

    {{-- ── Grid bawah ── --}}
    <div class="detail-grid">

        {{-- Kolom kiri --}}
        <div class="col-left">

            {{-- Info Pribadi --}}
            <div class="section-card">
                <div class="section-head">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Informasi Pribadi
                </div>
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Email Login</span>
                        <span class="info-val">{{ $mahasiswa->user?->email ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">No. HP</span>
                        <span class="info-val">{{ $mahasiswa->no_hp ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Alamat</span>
                        <span class="info-val">{{ $mahasiswa->alamat ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Terdaftar</span>
                        <span class="info-val">{{ $mahasiswa->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Pembayaran --}}
            <div class="section-card">
                <div class="section-head">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="1" y="4" width="22" height="16" rx="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                    Riwayat Pembayaran
                </div>
                @if($mahasiswa->pembayaran->isEmpty())
                    <p class="empty-text">Belum ada data pembayaran.</p>
                @else
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Semester</th>
                                <th>Tagihan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswa->pembayaran as $bayar)
                            <tr>
                                <td>{{ $bayar->semester }}</td>
                                <td>Rp {{ number_format($bayar->tagihan, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $bayar->status === 'lunas' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($bayar->status) }}
                                    </span>
                                </td>
                                <td>{{ $bayar->tanggal_bayar ? \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>{{-- .col-left --}}

        {{-- Kolom kanan --}}
        <div class="col-right">

            {{-- KRS --}}
            <div class="section-card">
                <div class="section-head">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
                    </svg>
                    Kartu Rencana Studi (KRS)
                </div>
                @if($mahasiswa->krs->isEmpty())
                    <p class="empty-text">Belum ada KRS yang diambil.</p>
                @else
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Smt</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswa->krs as $krs)
                            @php $mk = $krs->jadwal?->mataKuliah; $j = $krs->jadwal; @endphp
                            <tr>
                                <td>
                                    <span class="mk-kode">{{ $mk?->kode_mk ?? '-' }}</span>
                                    {{ $mk?->nama_mk ?? '-' }}
                                </td>
                                <td class="center">{{ $mk?->sks ?? '-' }}</td>
                                <td class="center">{{ $mk?->semester ?? '-' }}</td>
                                <td>{{ $j?->hari ?? '-' }}</td>
                                <td class="nowrap">{{ $j?->jam_mulai ?? '-' }} – {{ $j?->jam_selesai ?? '-' }}</td>
                                <td>{{ $j?->ruangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Nilai --}}
            <div class="section-card">
                <div class="section-head">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                    Nilai Akademik
                </div>
                @if($mahasiswa->nilai->isEmpty())
                    <p class="empty-text">Belum ada nilai yang tercatat.</p>
                @else
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>Semester</th>
                                <th>Nilai</th>
                                <th>Angka</th>
                                <th>Ket.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mahasiswa->nilai as $n)
                            <tr>
                                <td>{{ $n->matakuliah?->nama_mk ?? '-' }}</td>
                                <td class="center">{{ $n->semester }}</td>
                                <td class="center">
                                    <span class="grade grade-{{ strtolower($n->nilai) }}">{{ $n->nilai }}</span>
                                </td>
                                <td class="center">{{ $n->angka }}</td>
                                <td>
                                    <span class="badge {{ $n->keterangan === 'Lulus' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $n->keterangan }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="tfoot-label">Rata-rata Angka (IPK)</td>
                                <td class="center fw-bold">
                                    {{ number_format($mahasiswa->nilai->avg('angka'), 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                @endif
            </div>

        </div>{{-- .col-right --}}
    </div>{{-- .detail-grid --}}

</div>
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 1100px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }

    /* ── Header ── */
    .page-header {
        display: flex; align-items: center; gap: 1rem;
        flex-wrap: wrap; margin-bottom: 1.5rem;
    }
    .header-info { flex: 1; }
    .header-info h1 { font-size: 1.3rem; font-weight: 700; color: #111827; margin: 0; }
    .header-info p  { font-size: .83rem; color: #6b7280; margin: 2px 0 0; }
    .header-actions { display: flex; gap: .5rem; flex-wrap: wrap; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: .84rem; color: #6b7280; text-decoration: none;
        padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 8px;
        transition: all .15s; white-space: nowrap;
    }
    .btn-back:hover { background: #f3f4f6; color: #111827; }

    .btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: .45rem 1rem; border-radius: 8px;
        font-size: .84rem; font-weight: 600; border: none;
        cursor: pointer; text-decoration: none; transition: all .15s;
    }
    .btn-warning { background: #fef3c7; color: #92400e; }
    .btn-warning:hover { background: #fde68a; }
    .btn-danger  { background: #fee2e2; color: #991b1b; }
    .btn-danger:hover  { background: #fecaca; }

    /* ── Profile Card ── */
    .profile-card {
        display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        border-radius: 16px; padding: 1.75rem 2rem;
        color: #fff; margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(99,102,241,.3);
    }
    .profile-avatar {
        width: 64px; height: 64px; border-radius: 50%;
        background: rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; font-weight: 700; flex-shrink: 0;
        border: 2px solid rgba(255,255,255,.4);
    }
    .profile-main { flex: 1; min-width: 0; }
    .profile-main h2 { font-size: 1.25rem; font-weight: 700; margin: 0 0 4px; }
    .nim-badge {
        display: inline-block; background: rgba(255,255,255,.2);
        border-radius: 20px; padding: 2px 12px; font-size: .8rem;
        font-weight: 600; letter-spacing: .5px; margin-bottom: 8px;
    }
    .profile-meta { display: flex; gap: 1rem; flex-wrap: wrap; font-size: .83rem; opacity: .9; }
    .profile-meta span { display: flex; align-items: center; gap: 4px; }
    .smt-aktif { background: rgba(255,255,255,.2); border-radius: 20px; padding: 2px 10px; }

    .profile-stats {
        display: flex; gap: 1.5rem; border-left: 1px solid rgba(255,255,255,.2);
        padding-left: 1.5rem; flex-wrap: wrap;
    }
    .stat { display: flex; flex-direction: column; align-items: center; gap: 2px; }
    .stat-val { font-size: 1.4rem; font-weight: 700; }
    .stat-lbl { font-size: .72rem; opacity: .8; white-space: nowrap; }
    .text-success { color: #6ee7b7; }
    .text-danger  { color: #fca5a5; }

    /* ── Grid ── */
    .detail-grid { display: grid; grid-template-columns: 340px 1fr; gap: 1.25rem; }
    .col-left, .col-right { display: flex; flex-direction: column; gap: 1.25rem; }

    /* ── Section Card ── */
    .section-card {
        background: #fff; border: 1px solid #e5e7eb;
        border-radius: 12px; overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
    }
    .section-head {
        display: flex; align-items: center; gap: 8px;
        padding: .9rem 1.25rem; border-bottom: 1px solid #f3f4f6;
        font-size: .88rem; font-weight: 700; color: #374151;
        background: #fafafa;
    }

    /* ── Info List ── */
    .info-list { padding: .5rem 0; }
    .info-row {
        display: flex; justify-content: space-between; align-items: flex-start;
        gap: 1rem; padding: .65rem 1.25rem;
        border-bottom: 1px solid #f9fafb; font-size: .855rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #6b7280; white-space: nowrap; flex-shrink: 0; }
    .info-val { color: #111827; font-weight: 500; text-align: right; word-break: break-word; }

    /* ── Mini Table ── */
    .mini-table { width: 100%; border-collapse: collapse; font-size: .83rem; }
    .mini-table th {
        padding: .6rem 1rem; text-align: left; font-size: .75rem;
        font-weight: 700; color: #6b7280; text-transform: uppercase;
        letter-spacing: .04em; background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    .mini-table td {
        padding: .65rem 1rem; color: #374151;
        border-bottom: 1px solid #f3f4f6; vertical-align: middle;
    }
    .mini-table tbody tr:last-child td { border-bottom: none; }
    .mini-table tbody tr:hover { background: #fafafa; }
    .mini-table tfoot td {
        padding: .65rem 1rem; background: #f9fafb;
        border-top: 2px solid #e5e7eb; font-size: .83rem; color: #374151;
    }
    .tfoot-label { color: #6b7280; font-style: italic; }
    .fw-bold { font-weight: 700; color: #4f46e5; }
    .center { text-align: center; }
    .nowrap { white-space: nowrap; }

    .mk-kode {
        display: inline-block; background: #ede9fe; color: #6d28d9;
        border-radius: 4px; padding: 1px 6px; font-size: .72rem;
        font-weight: 600; margin-right: 4px;
    }

    /* ── Badge ── */
    .badge {
        display: inline-block; padding: 2px 10px;
        border-radius: 20px; font-size: .74rem; font-weight: 600;
    }
    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-danger  { background: #fee2e2; color: #991b1b; }

    /* ── Grade ── */
    .grade {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px; border-radius: 6px;
        font-weight: 700; font-size: .85rem;
    }
    .grade-a  { background: #d1fae5; color: #065f46; }
    .grade-b  { background: #dbeafe; color: #1e40af; }
    .grade-c  { background: #fef3c7; color: #92400e; }
    .grade-d  { background: #fee2e2; color: #991b1b; }
    .grade-e  { background: #f3f4f6; color: #6b7280; }

    .empty-text {
        padding: 1.5rem 1.25rem; color: #9ca3af;
        font-size: .85rem; font-style: italic; margin: 0;
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .detail-grid { grid-template-columns: 1fr; }
        .profile-stats { border-left: none; padding-left: 0; border-top: 1px solid rgba(255,255,255,.2); padding-top: 1rem; width: 100%; justify-content: space-around; }
    }
    @media (max-width: 600px) {
        .profile-card { padding: 1.25rem; }
        .header-actions { width: 100%; }
        .btn { flex: 1; justify-content: center; }
    }
</style>
@endpush