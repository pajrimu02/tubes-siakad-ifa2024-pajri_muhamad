@extends('layouts.admin')

@section('title', 'Detail Jadwal')

@section('content')
<div class="page-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <a href="{{ route('jadwal.index') }}" class="btn-back">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Kembali
        </a>
        <div class="header-info">
            <h1>Detail Jadwal</h1>
            <p>Informasi lengkap jadwal perkuliahan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn btn-warning">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus jadwal ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6M9 6V4h6v2"/>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Profile Card --}}
    <div class="profile-card">
        <div class="profile-icon">
            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div class="profile-main">
            <h2>{{ $jadwal->mataKuliah?->nama_mk ?? '-' }}</h2>
            <span class="kode-label">{{ $jadwal->mataKuliah?->kode_mk ?? '-' }}</span>
            <div class="profile-meta">
                <span class="meta-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                    Kelas {{ $jadwal->kelas }}
                </span>
                <span class="meta-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $jadwal->hari }}
                </span>
                <span class="meta-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $jadwal->jam_mulai }} – {{ $jadwal->jam_selesai }}
                </span>
                <span class="meta-chip">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    {{ $jadwal->ruangan }}
                </span>
            </div>
        </div>
        <div class="profile-stats">
            <div class="stat">
                <span class="stat-val">{{ $jadwal->mataKuliah?->sks ?? '-' }}</span>
                <span class="stat-lbl">SKS</span>
            </div>
            <div class="stat">
                <span class="stat-val">{{ $jadwal->mataKuliah?->semester ?? '-' }}</span>
                <span class="stat-lbl">Semester</span>
            </div>
            <div class="stat">
                <span class="stat-val">{{ $jadwal->krs->count() }}</span>
                <span class="stat-lbl">Mahasiswa</span>
            </div>
        </div>
    </div>

    <div class="detail-grid">

        {{-- Info Jadwal --}}
        <div class="col-left">
            <div class="section-card">
                <div class="section-head">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Informasi Jadwal
                </div>
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Mata Kuliah</span>
                        <span class="info-val">{{ $jadwal->mataKuliah?->nama_mk ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kode MK</span>
                        <span class="info-val" style="font-family:monospace;">{{ $jadwal->mataKuliah?->kode_mk ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dosen</span>
                        <span class="info-val">{{ $jadwal->dosen?->nama ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">NIDN Dosen</span>
                        <span class="info-val">{{ $jadwal->dosen?->nidn ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Hari</span>
                        <span class="info-val">{{ $jadwal->hari }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jam</span>
                        <span class="info-val">{{ $jadwal->jam_mulai }} – {{ $jadwal->jam_selesai }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kelas</span>
                        <span class="info-val">{{ $jadwal->kelas }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ruangan</span>
                        <span class="info-val">{{ $jadwal->ruangan }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Mahasiswa (KRS) --}}
        <div class="col-right">
            <div class="section-card">
                <div class="section-head">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                    Mahasiswa Terdaftar ({{ $jadwal->krs->count() }})
                </div>
                @if($jadwal->krs->isEmpty())
                    <p class="empty-text">Belum ada mahasiswa yang mengambil jadwal ini.</p>
                @else
                    <table class="mini-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($jadwal->krs as $i => $krs)
                        <tr>
                            <td class="center text-muted">{{ $i + 1 }}</td>
                            <td>
                                <span style="font-family:monospace;font-size:12px;background:#f1f5f9;padding:2px 7px;border-radius:5px;color:#475569;">
                                    {{ $krs->mahasiswa?->nim ?? '-' }}
                                </span>
                            </td>
                            <td style="font-weight:500;color:#1e293b;">{{ $krs->mahasiswa?->nama ?? '-' }}</td>
                            <td class="center">{{ $krs->mahasiswa?->angkatan ?? '-' }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .page-wrapper { max-width: 1050px; margin: 0 auto; padding: 1.5rem 1rem 3rem; }
    .page-header { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
    .header-info { flex: 1; }
    .header-info h1 { font-size: 1.3rem; font-weight: 700; color: #111827; margin: 0; }
    .header-info p  { font-size: .83rem; color: #6b7280; margin: 2px 0 0; }
    .header-actions { display: flex; gap: .5rem; flex-wrap: wrap; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; font-size: .84rem; color: #6b7280; text-decoration: none; padding: 6px 12px; border: 1px solid #e5e7eb; border-radius: 8px; transition: all .15s; }
    .btn-back:hover { background: #f3f4f6; color: #111827; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: .45rem 1rem; border-radius: 8px; font-size: .84rem; font-weight: 600; border: none; cursor: pointer; text-decoration: none; transition: all .15s; }
    .btn-warning { background: #fef3c7; color: #92400e; }
    .btn-warning:hover { background: #fde68a; }
    .btn-danger { background: #fee2e2; color: #991b1b; }
    .btn-danger:hover { background: #fecaca; }

    .profile-card { display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; background: linear-gradient(135deg,#6366f1,#8b5cf6); border-radius: 16px; padding: 1.75rem 2rem; color: #fff; margin-bottom: 1.5rem; box-shadow: 0 4px 20px rgba(99,102,241,.3); }
    .profile-icon { width: 64px; height: 64px; border-radius: 14px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 2px solid rgba(255,255,255,.3); }
    .profile-main { flex: 1; min-width: 0; }
    .profile-main h2 { font-size: 1.2rem; font-weight: 700; margin: 0 0 4px; }
    .kode-label { display: inline-block; background: rgba(255,255,255,.2); border-radius: 6px; padding: 2px 10px; font-size: .78rem; font-weight: 700; font-family: monospace; margin-bottom: 8px; }
    .profile-meta { display: flex; gap: .6rem; flex-wrap: wrap; }
    .meta-chip { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 999px; font-size: .8rem; font-weight: 500; background: rgba(255,255,255,.18); }
    .profile-stats { display: flex; gap: 1.5rem; border-left: 1px solid rgba(255,255,255,.2); padding-left: 1.5rem; }
    .stat { display: flex; flex-direction: column; align-items: center; gap: 2px; }
    .stat-val { font-size: 1.4rem; font-weight: 700; }
    .stat-lbl { font-size: .72rem; opacity: .8; white-space: nowrap; }

    .detail-grid { display: grid; grid-template-columns: 320px 1fr; gap: 1.25rem; }
    .col-left, .col-right { display: flex; flex-direction: column; gap: 1.25rem; }
    .section-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.05); }
    .section-head { display: flex; align-items: center; gap: 8px; padding: .9rem 1.25rem; border-bottom: 1px solid #f3f4f6; font-size: .88rem; font-weight: 700; color: #374151; background: #fafafa; }
    .info-list { padding: .5rem 0; }
    .info-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; padding: .65rem 1.25rem; border-bottom: 1px solid #f9fafb; font-size: .855rem; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #6b7280; white-space: nowrap; flex-shrink: 0; }
    .info-val { color: #111827; font-weight: 500; text-align: right; word-break: break-word; }
    .mini-table { width: 100%; border-collapse: collapse; font-size: .83rem; }
    .mini-table th { padding: .6rem 1rem; text-align: left; font-size: .75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .04em; background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
    .mini-table td { padding: .65rem 1rem; color: #374151; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .mini-table tbody tr:last-child td { border-bottom: none; }
    .mini-table tbody tr:hover { background: #fafafa; }
    .center { text-align: center; }
    .text-muted { color: #94a3b8; }
    .empty-text { padding: 1.5rem 1.25rem; color: #9ca3af; font-size: .85rem; font-style: italic; margin: 0; }

    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } .profile-stats { border-left: none; padding-left: 0; border-top: 1px solid rgba(255,255,255,.2); padding-top: 1rem; width: 100%; justify-content: space-around; } }
    @media (max-width: 600px) { .profile-card { padding: 1.25rem; } .header-actions { width: 100%; } .btn { flex: 1; justify-content: center; } }
</style>
@endpush