@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

*, *::before, *::after { box-sizing: border-box; }
.dash-wrap * { font-family: 'Inter', sans-serif; }

.dash-wrap {
    display: flex; flex-direction: column;
    gap: 16px; padding: 4px 0 20px;
}

/* ══════════════════════
   STAT CARDS
══════════════════════ */
.stat-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

.stat-card {
    border-radius: 18px;
    padding: 20px;
    position: relative;
    overflow: hidden;
    cursor: default;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1),
                box-shadow .25s ease;
    border: none;
}
.stat-card:hover { transform: translateY(-5px) scale(1.02); }

.stat-card.blue  {
    background: linear-gradient(135deg, #1967d2 0%, #3b82f6 50%, #60a5fa 100%);
    box-shadow: 0 4px 20px rgba(25,103,210,.25);
}
.stat-card.green {
    background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
    box-shadow: 0 4px 20px rgba(5,150,105,.25);
}
.stat-card.amber {
    background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
    box-shadow: 0 4px 20px rgba(217,119,6,.25);
}
.stat-card.purple {
    background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #a78bfa 100%);
    box-shadow: 0 4px 20px rgba(124,58,237,.25);
}

.stat-card:hover.blue   { box-shadow: 0 14px 36px rgba(25,103,210,.45); }
.stat-card:hover.green  { box-shadow: 0 14px 36px rgba(5,150,105,.45); }
.stat-card:hover.amber  { box-shadow: 0 14px 36px rgba(217,119,6,.45); }
.stat-card:hover.purple { box-shadow: 0 14px 36px rgba(124,58,237,.45); }

/* animated blob behind */
.stat-blob {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    transition: transform .4s ease;
}
.blob-1 { width:110px;height:110px; top:-30px; right:-25px; }
.blob-2 { width:60px; height:60px;  bottom:-15px; left:-10px; background: rgba(255,255,255,0.07); }
.stat-card:hover .blob-1 { transform: scale(1.3) rotate(15deg); }

.stat-icon {
    width: 46px; height: 46px; border-radius: 13px;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 19px; color: #fff; flex-shrink: 0;
    margin-bottom: 14px;
    transition: transform .25s cubic-bezier(.34,1.56,.64,1);
    backdrop-filter: blur(4px);
}
.stat-card:hover .stat-icon { transform: scale(1.15) rotate(-8deg); }

.stat-label {
    font-size: 11px; color: rgba(255,255,255,.75);
    letter-spacing:.06em; text-transform: uppercase;
    font-weight: 700; margin: 0;
}
.stat-value {
    font-size: 32px; font-weight: 900; color: #fff;
    margin: 4px 0 0; line-height: 1; letter-spacing: -1px;
}
.stat-trend {
    margin-top: 10px;
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 8px; border-radius: 20px;
    background: rgba(255,255,255,0.18);
    font-size: 11px; font-weight: 600; color: #fff;
}

/* ══════════════════════
   GRID LAYOUT
══════════════════════ */
.grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
.grid-2 { display: grid; grid-template-columns: 1.8fr 1fr; gap: 14px; }

/* ══════════════════════
   CHART CARDS
══════════════════════ */
.chart-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    padding: 18px 20px;
    display: flex; flex-direction: column;
    transition: box-shadow .25s ease, transform .25s ease;
    position: relative; overflow: hidden;
}
.chart-card:hover {
    box-shadow: 0 10px 32px rgba(0,0,0,.1);
    transform: translateY(-2px);
}

/* top accent bar per chart */
.chart-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 3px; border-radius: 18px 18px 0 0;
}
.accent-blue::before   { background: linear-gradient(90deg,#1967d2,#60a5fa); }
.accent-green::before  { background: linear-gradient(90deg,#059669,#34d399); }
.accent-amber::before  { background: linear-gradient(90deg,#d97706,#fbbf24); }
.accent-purple::before { background: linear-gradient(90deg,#7c3aed,#a78bfa); }
.accent-rose::before   { background: linear-gradient(90deg,#e11d48,#fb7185); }

.chart-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px;
}
.chart-title {
    font-size: 13px; font-weight: 700; color: #1e293b;
    display: flex; align-items: center; gap: 8px; margin: 0;
}
.chart-title i { font-size: 13px; }

.chart-badge {
    font-size: 10.5px; font-weight: 600;
    padding: 3px 10px; border-radius: 20px;
    display: inline-flex; align-items: center; gap: 4px;
}
.cb-blue   { background:#eff6ff; color:#1967d2; }
.cb-green  { background:#ecfdf5; color:#059669; }
.cb-amber  { background:#fffbeb; color:#d97706; }
.cb-purple { background:#f5f3ff; color:#7c3aed; }

.chart-body { flex: 1; position: relative; min-height: 150px; }
.chart-body canvas {
    position: absolute; inset: 0;
    width: 100% !important; height: 100% !important;
}

/* ══════════════════════
   STATS MINI ROW (under charts)
══════════════════════ */
.mini-stats {
    display: flex; gap: 0;
    border-top: 1px solid #f1f5f9;
    margin-top: 14px; padding-top: 12px;
}
.mini-stat {
    flex: 1; text-align: center;
    border-right: 1px solid #f1f5f9;
    padding: 0 8px;
}
.mini-stat:last-child { border-right: none; }
.mini-stat-val { font-size: 16px; font-weight: 800; color: #1e293b; }
.mini-stat-lbl { font-size: 10px; color: #94a3b8; font-weight: 600; text-transform: uppercase; }

/* ══════════════════════
   TABLE CARD
══════════════════════ */
.tbl-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    overflow: hidden;
    transition: box-shadow .25s ease;
    position: relative;
}
.tbl-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0;
    height: 3px; border-radius: 18px 18px 0 0;
    background: linear-gradient(90deg,#6366f1,#8b5cf6,#a78bfa);
}
.tbl-card:hover { box-shadow: 0 10px 32px rgba(0,0,0,.1); }

.tbl-head {
    padding: 16px 20px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid #f8fafc;
}
.tbl-head h6 {
    font-size: 13px; font-weight: 700; color: #1e293b;
    margin: 0; display: flex; align-items: center; gap: 7px;
}

.dash-table { width: 100%; border-collapse: collapse; }
.dash-table thead th {
    background: #fafbff;
    color: #94a3b8; font-size: 10.5px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .06em;
    padding: 10px 16px; border-bottom: 1px solid #f1f5f9;
    white-space: nowrap;
}
.dash-table tbody td {
    padding: 11px 16px; font-size: 13px; color: #334155;
    border-bottom: 1px solid #f8fafc; vertical-align: middle;
}
.dash-table tbody tr:last-child td { border-bottom: none; }
.dash-table tbody tr {
    transition: background .15s ease;
    animation: rowSlide .35s ease both;
}
.dash-table tbody tr:hover td { background: #f5f3ff; }
@keyframes rowSlide {
    from { opacity: 0; transform: translateX(-8px); }
    to   { opacity: 1; transform: translateX(0); }
}

/* rank badge */
.rank {
    display: inline-flex; align-items: center; justify-content: center;
    width: 24px; height: 24px; border-radius: 7px;
    font-size: 11px; font-weight: 800;
}
.r1 { background: linear-gradient(135deg,#fef08a,#fbbf24); color: #92400e; }
.r2 { background: linear-gradient(135deg,#e2e8f0,#cbd5e1); color: #475569; }
.r3 { background: linear-gradient(135deg,#fed7aa,#fdba74); color: #9a3412; }
.rn { background: #f8fafc; color: #94a3b8; }

/* progress bar */
.prog-wrap { display: flex; align-items: center; gap: 8px; }
.prog-bg { flex: 1; height: 6px; background: #f1f5f9; border-radius: 99px; overflow: hidden; }
.prog-fill { height: 100%; border-radius: 99px; transition: width 1.2s cubic-bezier(.34,1,.64,1); }
.prog-val { font-size: 12px; font-weight: 700; color: #1e293b; min-width: 28px; text-align: right; }

/* ══════════════════════
   ACTIVITY / PIE CARD
══════════════════════ */
.pie-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    padding: 18px 20px;
    display: flex; flex-direction: column;
    transition: box-shadow .25s ease, transform .25s ease;
    position: relative; overflow: hidden;
}
.pie-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0;
    height: 3px; border-radius: 18px 18px 0 0;
    background: linear-gradient(90deg,#e11d48,#f97316,#fbbf24);
}
.pie-card:hover {
    box-shadow: 0 10px 32px rgba(0,0,0,.1);
    transform: translateY(-2px);
}
.pie-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 12px;
}
.pie-head h6 {
    font-size: 13px; font-weight: 700; color: #1e293b;
    margin: 0; display: flex; align-items: center; gap: 7px;
}
.pie-wrap { position: relative; height: 160px; }
.pie-wrap canvas {
    position: absolute; inset: 0;
    width: 100% !important; height: 100% !important;
}
/* center label */
.pie-center {
    position: absolute; inset: 0;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    pointer-events: none;
}
.pie-center-val { font-size: 22px; font-weight: 900; color: #1e293b; line-height: 1; }
.pie-center-lbl { font-size: 10px; color: #94a3b8; font-weight: 600; text-transform: uppercase; margin-top: 2px; }

.pie-legend {
    margin-top: 14px; display: flex; flex-direction: column; gap: 8px;
}
.pie-item {
    display: flex; align-items: center; justify-content: space-between;
    padding: 8px 12px; border-radius: 10px;
    background: #fafbff; border: 1px solid #f1f5f9;
    cursor: default;
    transition: background .18s, transform .18s, box-shadow .18s;
}
.pie-item:hover {
    background: #f0f4ff;
    transform: translateX(4px);
    box-shadow: 0 2px 8px rgba(99,102,241,.1);
}
.pie-item-left { display: flex; align-items: center; gap: 9px; }
.pie-dot { width: 10px; height: 10px; border-radius: 4px; flex-shrink: 0; }
.pie-name { font-size: 12.5px; font-weight: 600; color: #374151; }
.pie-num  { font-size: 13px; font-weight: 800; color: #1e293b; }

/* ══════════════════════
   RECENT ACTIVITY
══════════════════════ */
.activity-list { display: flex; flex-direction: column; gap: 0; }
.act-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 11px 0;
    border-bottom: 1px solid #f8fafc;
    transition: background .15s;
    animation: rowSlide .35s ease both;
}
.act-item:last-child { border-bottom: none; }
.act-item:hover { background: #fafbff; border-radius: 10px; padding: 11px 8px; }
.act-dot-wrap { display: flex; flex-direction: column; align-items: center; gap: 0; padding-top: 3px; }
.act-dot {
    width: 28px; height: 28px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; flex-shrink: 0;
}
.act-line { width: 1px; flex: 1; background: #f1f5f9; margin-top: 4px; min-height: 16px; }
.act-text { flex: 1; }
.act-title { font-size: 12.5px; font-weight: 600; color: #1e293b; line-height: 1.4; }
.act-sub   { font-size: 11px; color: #94a3b8; margin-top: 2px; }
.act-time  { font-size: 10.5px; color: #cbd5e1; font-weight: 500; white-space: nowrap; }

/* ══════════════════════
   ANIMATIONS
══════════════════════ */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@section('content')
<div class="dash-wrap">

    {{-- ══ STAT CARDS ══ --}}
    <div class="stat-row">

        <div class="stat-card blue" style="animation:fadeUp .5s ease .00s both">
            <div class="stat-blob blob-1"></div>
            <div class="stat-blob blob-2"></div>
            <div class="stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
            <p class="stat-label">Total Mahasiswa</p>
            <p class="stat-value">{{ $mahasiswa }}</p>
            <span class="stat-trend">
                <i class="fa-solid fa-arrow-trend-up" style="font-size:10px;"></i>
                Aktif terdaftar
            </span>
        </div>

        <div class="stat-card green" style="animation:fadeUp .5s ease .07s both">
            <div class="stat-blob blob-1"></div>
            <div class="stat-blob blob-2"></div>
            <div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
            <p class="stat-label">Total Dosen</p>
            <p class="stat-value">{{ $dosen }}</p>
            <span class="stat-trend">
                <i class="fa-solid fa-circle-check" style="font-size:10px;"></i>
                Pengajar aktif
            </span>
        </div>

        <div class="stat-card amber" style="animation:fadeUp .5s ease .14s both">
            <div class="stat-blob blob-1"></div>
            <div class="stat-blob blob-2"></div>
            <div class="stat-icon"><i class="fa-solid fa-book-open"></i></div>
            <p class="stat-label">Mata Kuliah</p>
            <p class="stat-value">{{ $matakuliah }}</p>
            <span class="stat-trend">
                <i class="fa-solid fa-layer-group" style="font-size:10px;"></i>
                Tersedia semester ini
            </span>
        </div>

        <div class="stat-card purple" style="animation:fadeUp .5s ease .21s both">
            <div class="stat-blob blob-1"></div>
            <div class="stat-blob blob-2"></div>
            <div class="stat-icon"><i class="fa-solid fa-file-signature"></i></div>
            <p class="stat-label">Total KRS</p>
            <p class="stat-value">{{ $krs }}</p>
            <span class="stat-trend">
                <i class="fa-solid fa-arrow-trend-up" style="font-size:10px;"></i>
                KRS diproses
            </span>
        </div>

    </div>

    {{-- ══ CHARTS ROW 1 — Line + Bar MK + Bar Horizontal ══ --}}
    <div class="grid-3">

        {{-- Line Chart --}}
        <div class="chart-card accent-blue" style="animation:fadeUp .5s ease .10s both">
            <div class="chart-head">
                <p class="chart-title" style="color:#1967d2">
                    <i class="fa-solid fa-chart-line"></i> Trend KRS per Semester
                </p>
                <span class="chart-badge cb-blue">
                    <i class="fa-solid fa-circle" style="font-size:6px;"></i> Live
                </span>
            </div>
            <div class="chart-body"><canvas id="angkatanChart"></canvas></div>
            <div class="mini-stats">
                <div class="mini-stat">
                    <div class="mini-stat-val">{{ collect($angkatan_data)->sum() }}</div>
                    <div class="mini-stat-lbl">Total</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-val">{{ collect($angkatan_labels)->count() }}</div>
                    <div class="mini-stat-lbl">Semester</div>
                </div>
                <div class="mini-stat">
                    <div class="mini-stat-val">{{ collect($angkatan_data)->max() ?? 0 }}</div>
                    <div class="mini-stat-lbl">Tertinggi</div>
                </div>
            </div>
        </div>

        {{-- Bar MK --}}
        <div class="chart-card accent-green" style="animation:fadeUp .5s ease .17s both">
            <div class="chart-head">
                <p class="chart-title" style="color:#059669">
                    <i class="fa-solid fa-ranking-star"></i> MK Terpopuler
                </p>
                <span class="chart-badge cb-green">Top {{ count($mk_labels ?? []) }}</span>
            </div>
            <div class="chart-body"><canvas id="mkChart"></canvas></div>
            <div class="mini-stats">
                <div class="mini-stat">
                    <div class="mini-stat-val">{{ collect($mk_data)->sum() }}</div>
                    <div class="mini-stat-lbl">Total Peserta</div>
                </div>
                <div class="mini-stat">
                    
                    <div class="mini-stat-val">{{ collect($mk_data)->max() ?? 0 }}</div>
                    <div class="mini-stat-lbl">Terbanyak</div>
                </div>
            </div>
        </div>

        {{-- Bar Top Mahasiswa Horizontal --}}
        <div class="chart-card accent-amber" style="animation:fadeUp .5s ease .24s both">
            <div class="chart-head">
                <p class="chart-title" style="color:#d97706">
                    <i class="fa-solid fa-trophy"></i> Top Mahasiswa
                </p>
                <span class="chart-badge cb-amber">Aktivitas KRS</span>
            </div>
            <div class="chart-body"><canvas id="topMahasiswaChart"></canvas></div>
        </div>

    </div>

    {{-- ══ BOTTOM ROW — Table + Doughnut ══ --}}
    <div class="grid-2">

        {{-- Table MK Terpopuler --}}
        <div class="tbl-card" style="animation:fadeUp .5s ease .28s both">
            <div class="tbl-head">
                <h6>
                    <i class="fa-solid fa-ranking-star" style="color:#6366f1;"></i>
                    Mata Kuliah Terpopuler
                </h6>
                <span style="font-size:11px;font-weight:600;padding:3px 10px;
                             border-radius:20px;background:#ede9fe;color:#5b21b6;">
                    Top {{ count($mk_labels ?? []) }}
                </span>
            </div>
            <table class="dash-table">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Mata Kuliah</th>
                        <th>Popularitas</th>
                        <th width="60">Peserta</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $palette = ['#1967d2','#059669','#d97706','#e11d48','#6366f1','#0d9488','#9333ea','#0284c7'];
                    $maxMk = collect($mk_data)->max() ?: 1;
                @endphp
                @foreach($mk_labels as $i => $label)
                @php
                    $val = $mk_data[$i] ?? 0;
                    $pct = $maxMk > 0 ? round($val / $maxMk * 100) : 0;
                    $col = $palette[$i % count($palette)];
                    $rc  = match($i) { 0 => 'r1', 1 => 'r2', 2 => 'r3', default => 'rn' };
                @endphp
                <tr style="animation-delay:{{ $i * 0.05 }}s">
                    <td><span class="rank {{ $rc }}">{{ $i + 1 }}</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="width:9px;height:9px;border-radius:3px;
                                         background:{{ $col }};flex-shrink:0;display:inline-block;"></span>
                            <span style="font-weight:600;color:#1e293b;font-size:13px;">{{ $label }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="prog-wrap">
                            <div class="prog-bg">
                                <div class="prog-fill"
                                     style="width:{{ $pct }}%;background:{{ $col }};"></div>
                            </div>
                            <span class="prog-val">{{ $pct }}%</span>
                        </div>
                    </td>
                    <td>
                        <span style="font-weight:800;color:#1e293b;font-size:14px;">{{ $val }}</span>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Right column: Doughnut + Activity --}}
        <div style="display:flex;flex-direction:column;gap:14px;">

            {{-- Doughnut --}}
            <div class="pie-card" style="animation:fadeUp .5s ease .32s both">
                <div class="pie-head">
                    <h6>
                        <i class="fa-solid fa-chart-pie" style="color:#e11d48;"></i>
                        Distribusi Sistem
                    </h6>
                </div>
                <div class="pie-wrap">
                    <canvas id="pieChart"></canvas>
                    <div class="pie-center">
                        <span class="pie-center-val">{{ $mahasiswa + $dosen + $matakuliah + $krs }}</span>
                        <span class="pie-center-lbl">Total</span>
                    </div>
                </div>
                <div class="pie-legend">
                    @php
                        $pieData = [
                            ['Mahasiswa', $mahasiswa,   '#1967d2'],
                            ['Dosen',     $dosen,       '#059669'],
                            ['MK',        $matakuliah,  '#d97706'],
                            ['KRS',       $krs,         '#7c3aed'],
                        ];
                    @endphp
                    @foreach($pieData as [$name, $val, $col])
                    <div class="pie-item">
                        <div class="pie-item-left">
                            <span class="pie-dot" style="background:{{ $col }};"></span>
                            <span class="pie-name">{{ $name }}</span>
                        </div>
                        <span class="pie-num">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    Chart.defaults.font.family = 'Inter, sans-serif';

    const tick = { color: '#9ca3af', font: { size: 10, weight: '500' } };
    const grid = { color: 'rgba(0,0,0,0.04)', drawBorder: false };

    const tooltip = {
        backgroundColor: '#0f172a',
        padding: 10, cornerRadius: 10,
        titleColor: '#94a3b8',
        bodyColor: '#fff',
        titleFont: { size: 11, weight: '600' },
        bodyFont: { size: 14, weight: '700' },
        displayColors: false,
    };

    /* ── LINE CHART ── */
    new Chart(document.getElementById('angkatanChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($angkatan_labels) !!},
            datasets: [{
                label: 'KRS',
                data: {!! json_encode($angkatan_data) !!},
                borderColor: '#1967d2',
                backgroundColor: (ctx) => {
                    const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, ctx.chart.height);
                    g.addColorStop(0, 'rgba(25,103,210,0.3)');
                    g.addColorStop(1, 'rgba(25,103,210,0.0)');
                    return g;
                },
                borderWidth: 2.5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#1967d2',
                pointBorderWidth: 2.5,
                pointRadius: 5, pointHoverRadius: 7,
                fill: true, tension: 0.42
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            animation: { duration: 1000, easing: 'easeOutQuart' },
            plugins: { legend: { display: false }, tooltip },
            scales: { x: { ticks: tick, grid }, y: { ticks: tick, grid } }
        }
    });

    /* ── BAR MK ── */
    const mkColors = [
        'rgba(25,103,210,.8)','rgba(5,150,105,.8)','rgba(217,119,6,.8)',
        'rgba(225,29,72,.8)', 'rgba(99,102,241,.8)','rgba(13,148,136,.8)',
        'rgba(147,51,234,.8)','rgba(2,132,199,.8)'
    ];
    const mkHover = ['#1967d2','#059669','#d97706','#e11d48','#6366f1','#0d9488','#9333ea','#0284c7'];

    new Chart(document.getElementById('mkChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($mk_labels) !!},
            datasets: [{
                data: {!! json_encode($mk_data) !!},
                backgroundColor: mkColors,
                hoverBackgroundColor: mkHover,
                borderRadius: 8, borderSkipped: false,
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            animation: { duration: 1000, easing: 'easeOutBounce' },
            plugins: { legend: { display: false }, tooltip },
            scales: {
                x: { ticks: { ...tick, maxRotation: 30 }, grid: { display: false } },
                y: { ticks: tick, grid }
            }
        }
    });

    /* ── BAR HORIZONTAL (Top Mahasiswa) ── */
    const hmColors = [
        'rgba(217,119,6,.85)','rgba(225,29,72,.85)','rgba(99,102,241,.85)',
        'rgba(13,148,136,.85)','rgba(25,103,210,.85)'
    ];

    new Chart(document.getElementById('topMahasiswaChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($top_mahasiswa_labels) !!},
            datasets: [{
                data: {!! json_encode($top_mahasiswa_data) !!},
                backgroundColor: hmColors,
                borderRadius: 8, borderSkipped: false, borderWidth: 0,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            indexAxis: 'y',
            animation: { duration: 1100, easing: 'easeOutQuart' },
            plugins: { legend: { display: false }, tooltip },
            scales: {
                x: { ticks: tick, grid },
                y: { ticks: { ...tick, maxRotation: 0 }, grid: { display: false } }
            }
        }
    });

    /* ── DOUGHNUT ── */
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Mahasiswa', 'Dosen', 'Matakuliah', 'KRS'],
            datasets: [{
                data: [{{ $mahasiswa }}, {{ $dosen }}, {{ $matakuliah }}, {{ $krs }}],
                backgroundColor: ['#1967d2', '#059669', '#d97706', '#7c3aed'],
                hoverBackgroundColor: ['#1557b8', '#047857', '#b45309', '#6d28d9'],
                borderWidth: 4, borderColor: '#fff', hoverOffset: 10,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '68%',
            animation: { duration: 1200, easing: 'easeOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: { ...tooltip, displayColors: true }
            }
        }
    });

    /* ── PROGRESS BARS animate on load ── */
    document.querySelectorAll('.prog-fill').forEach(el => {
        const w = el.style.width;
        el.style.width = '0';
        setTimeout(() => { el.style.width = w; }, 300);
    });

});
</script>
@endpush