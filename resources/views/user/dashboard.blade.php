@extends('layouts.user')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* { box-sizing: border-box; }

/* ── HEADER ── */
.dash-header h3 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}
.dash-header small {
    font-size: 12px;
    color: #6b7280;
}

/* ── STAT CARDS ── */
.stat-card-wrap .card {
    border: 0.5px solid #e5e7eb !important;
    border-radius: 12px !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, border-color 0.2s ease;
    overflow: hidden;
    position: relative;
}

.stat-card-wrap .card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    opacity: 0;
    transition: opacity 0.2s ease;
    border-radius: 0 0 12px 12px;
}

.stat-card-wrap .card.c-blue::after  { background: #1967d2; }
.stat-card-wrap .card.c-green::after { background: #1e8e3e; }
.stat-card-wrap .card.c-amber::after { background: #d97706; }
.stat-card-wrap .card.c-red::after   { background: #dc2626; }

.stat-card-wrap .card.c-blue:hover  { background: #eff6ff; border-color: #bfdbfe !important; box-shadow: 0 8px 24px rgba(25,103,210,0.12) !important; transform: translateY(-3px); }
.stat-card-wrap .card.c-green:hover { background: #f0fdf4; border-color: #a7f3c0 !important; box-shadow: 0 8px 24px rgba(30,142,62,0.12) !important; transform: translateY(-3px); }
.stat-card-wrap .card.c-amber:hover { background: #fffbeb; border-color: #fcd34d !important; box-shadow: 0 8px 24px rgba(217,119,6,0.12) !important; transform: translateY(-3px); }
.stat-card-wrap .card.c-red:hover   { background: #fef2f2; border-color: #fca5a5 !important; box-shadow: 0 8px 24px rgba(220,38,38,0.12) !important; transform: translateY(-3px); }

.stat-card-wrap .card:hover::after { opacity: 1; }

.stat-icon-box {
    width: 46px; height: 46px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
    transition: transform 0.2s ease;
}

.stat-card-wrap .card:hover .stat-icon-box { transform: scale(1.1) rotate(-5deg); }

.stat-icon-box.blue  { background: #dbeafe; color: #1967d2; }
.stat-icon-box.green { background: #dcfce7; color: #1e8e3e; }
.stat-icon-box.amber { background: #fef3c7; color: #d97706; }
.stat-icon-box.red   { background: #fee2e2; color: #dc2626; }

.stat-label-text { font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin: 0; font-weight: 500; }
.stat-value-text { font-size: 22px; font-weight: 700; color: #111827; margin: 2px 0 0; line-height: 1; }

.stat-card-wrap .card.c-blue:hover  .stat-value-text { color: #1967d2; }
.stat-card-wrap .card.c-green:hover .stat-value-text { color: #1e8e3e; }
.stat-card-wrap .card.c-amber:hover .stat-value-text { color: #d97706; }
.stat-card-wrap .card.c-red:hover   .stat-value-text { color: #dc2626; }

/* ── QUICK MENU ── */
.menu-card-wrap a { text-decoration: none; }

.menu-card-wrap .card {
    border: 0.5px solid #e5e7eb !important;
    border-radius: 12px !important;
    transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease, border-color 0.22s ease;
    overflow: hidden;
    position: relative;
}

.menu-card-wrap .card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 12px 12px 0 0;
    opacity: 0;
    transition: opacity 0.22s ease;
}

.menu-card-wrap .card.m-blue::before  { background: linear-gradient(90deg,#1967d2,#60a5fa); }
.menu-card-wrap .card.m-green::before { background: linear-gradient(90deg,#1e8e3e,#4ade80); }
.menu-card-wrap .card.m-amber::before { background: linear-gradient(90deg,#d97706,#fbbf24); }
.menu-card-wrap .card.m-red::before   { background: linear-gradient(90deg,#dc2626,#f87171); }

.menu-card-wrap .card.m-blue:hover  { background: #eff6ff; border-color: #bfdbfe !important; box-shadow: 0 8px 24px rgba(25,103,210,0.13) !important; transform: translateY(-4px); }
.menu-card-wrap .card.m-green:hover { background: #f0fdf4; border-color: #a7f3c0 !important; box-shadow: 0 8px 24px rgba(30,142,62,0.13) !important; transform: translateY(-4px); }
.menu-card-wrap .card.m-amber:hover { background: #fffbeb; border-color: #fcd34d !important; box-shadow: 0 8px 24px rgba(217,119,6,0.13) !important; transform: translateY(-4px); }
.menu-card-wrap .card.m-red:hover   { background: #fef2f2; border-color: #fca5a5 !important; box-shadow: 0 8px 24px rgba(220,38,38,0.13) !important; transform: translateY(-4px); }

.menu-card-wrap .card:hover::before { opacity: 1; }

.menu-icon-box {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    margin: 0 auto 10px;
    transition: transform 0.22s ease, box-shadow 0.22s ease;
}

.menu-card-wrap .card:hover .menu-icon-box { transform: scale(1.12) rotate(-6deg); }

.menu-icon-box.blue  { background: #dbeafe; color: #1967d2; }
.menu-icon-box.green { background: #dcfce7; color: #1e8e3e; }
.menu-icon-box.amber { background: #fef3c7; color: #d97706; }
.menu-icon-box.red   { background: #fee2e2; color: #dc2626; }

.menu-label {
    font-size: 12.5px;
    font-weight: 600;
    color: #374151;
    margin: 0;
    letter-spacing: 0.01em;
}

.menu-card-wrap .card.m-blue:hover  .menu-label { color: #1967d2; }
.menu-card-wrap .card.m-green:hover .menu-label { color: #1e8e3e; }
.menu-card-wrap .card.m-amber:hover .menu-label { color: #d97706; }
.menu-card-wrap .card.m-red:hover   .menu-label { color: #dc2626; }

/* ── TABLE CARD ── */
.table-outer-card {
    border: 0.5px solid #e5e7eb !important;
    border-radius: 12px !important;
    overflow: hidden;
}

.table-outer-card .card-header {
    background: #fff !important;
    border-bottom: 0.5px solid #f3f4f6 !important;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.table-outer-card .card-header h5 {
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #374151;
    margin: 0;
}

.table-outer-card .card-header i {
    color: #9ca3af;
    font-size: 13px;
}

.table-outer-card .table thead th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #9ca3af;
    font-weight: 600;
    border-bottom: 0.5px solid #f3f4f6;
    background: #fafafa;
    padding: 10px 14px;
}

.table-outer-card .table tbody td {
    font-size: 13px;
    color: #374151;
    padding: 10px 14px;
    border-bottom: 0.5px solid #f9fafb;
    vertical-align: middle;
}

.table-outer-card .table tbody tr {
    transition: background 0.15s ease;
}

.table-outer-card .table tbody tr:hover td {
    background: #f8faff;
    color: #1967d2;
}

.badge-semester {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    background: #eff6ff;
    color: #1967d2;
}

.badge-kelas {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    background: #f0fdf4;
    color: #1e8e3e;
}
</style>

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 dash-header">
        <div>
            <h3 class="mb-0">Dashboard Mahasiswa</h3>
            <small class="text-muted">Selamat datang, {{ auth()->user()->name }}</small>
        </div>
    </div>

    {{-- STAT CARD --}}
    <div class="row g-3 mb-4 stat-card-wrap">

        <div class="col-md-3">
            <div class="card shadow-sm border-0 c-blue">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box blue">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <div>
                        <p class="stat-label-text">Total KRS</p>
                        <p class="stat-value-text">{{ $krs->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 c-green">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box green">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <p class="stat-label-text">Jadwal Aktif</p>
                        <p class="stat-value-text">{{ $krs->unique('jadwal_id')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 c-amber">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box amber">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div>
                        <p class="stat-label-text">Semester Aktif</p>
                        <p class="stat-value-text">{{ $krs->max('semester') ?? 1 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 c-red">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box red">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <p class="stat-label-text">Status</p>
                        <p class="stat-value-text">Aktif</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- QUICK MENU --}}
    <div class="row g-3 mb-4 menu-card-wrap">

        <div class="col-md-3">
            <a href="{{ route('user.krs.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 hover-card m-blue">
                    <div class="card-body text-center py-4">
                        <div class="menu-icon-box blue mx-auto">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <p class="menu-label">KRS Saya</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('user.jadwal.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 hover-card m-green">
                    <div class="card-body text-center py-4">
                        <div class="menu-icon-box green mx-auto">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <p class="menu-label">Jadwal</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('user.nilai.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 hover-card m-amber">
                    <div class="card-body text-center py-4">
                        <div class="menu-icon-box amber mx-auto">
                            <i class="fa-solid fa-chart-bar"></i>
                        </div>
                        <p class="menu-label">Nilai</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="{{ route('user.profil.index') }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 hover-card m-red">
                    <div class="card-body text-center py-4">
                        <div class="menu-icon-box red mx-auto">
                            <i class="fa-solid fa-circle-user"></i>
                        </div>
                        <p class="menu-label">Profil</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

    {{-- TABLE KRS TERBARU --}}
    <div class="card shadow-sm border-0 table-outer-card">

        <div class="card-header bg-white">
            <i class="fa-solid fa-table-list"></i>
            <h5 class="mb-0">KRS Terbaru</h5>
        </div>

        <div class="card-body table-responsive p-0">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Mata Kuliah</th>
                        <th>Semester</th>
                        <th>Kelas</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($krs as $key => $k)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $k->jadwal->mataKuliah->nama_mk ?? '-' }}</td>
                            <td><span class="badge-semester">Sem {{ $k->semester }}</span></td>
                            <td><span class="badge-kelas">{{ $k->jadwal->kelas ?? '-' }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fa-solid fa-inbox fa-lg mb-2 d-block opacity-25"></i>
                                Belum ada data KRS
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

@endsection