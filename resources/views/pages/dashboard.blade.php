@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* { box-sizing: border-box; }

.dash-wrap {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 12px 0;
    height: calc(100vh - 80px);
    max-height: 900px;
}

/* ── STAT CARDS ── */
.stat-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

.stat-card {
    background: #fff;
    border: 0.5px solid #e0e0e0;
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease, background 0.22s ease;
    cursor: default;
    position: relative;
    overflow: hidden;
}

.stat-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 0 0 10px 10px;
    opacity: 0;
    transition: opacity 0.22s ease;
}

.stat-card.blue::after  { background: #1967d2; }
.stat-card.green::after { background: #1e8e3e; }
.stat-card.amber::after { background: #e37400; }
.stat-card.red::after   { background: #d93025; }

.stat-card.blue:hover  { background: #eef3fd; border-color: #a8c0f3; box-shadow: 0 6px 22px rgba(25,103,210,0.14); transform: translateY(-3px); }
.stat-card.green:hover { background: #edf7ef; border-color: #93d19f; box-shadow: 0 6px 22px rgba(30,142,62,0.14); transform: translateY(-3px); }
.stat-card.amber:hover { background: #fef8ee; border-color: #f5c97a; box-shadow: 0 6px 22px rgba(227,116,0,0.14); transform: translateY(-3px); }
.stat-card.red:hover   { background: #fef0ef; border-color: #f5a09a; box-shadow: 0 6px 22px rgba(217,48,37,0.14); transform: translateY(-3px); }

.stat-card:hover::after { opacity: 1; }

.stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
    transition: transform 0.22s ease;
}

.stat-card:hover .stat-icon { transform: scale(1.1) rotate(-4deg); }

.stat-icon.blue   { background: #dbeafe; color: #1967d2; }
.stat-icon.green  { background: #dcfce7; color: #1e8e3e; }
.stat-icon.amber  { background: #fef3c7; color: #e37400; }
.stat-icon.red    { background: #fee2e2; color: #d93025; }

.stat-info { min-width: 0; }

.stat-label {
    font-size: 11px;
    color: #6b7280;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
    font-weight: 500;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #111827;
    margin: 4px 0 0;
    line-height: 1;
    animation: countUp 0.6s ease-out both;
}

.stat-card.blue:hover  .stat-value { color: #1967d2; }
.stat-card.green:hover .stat-value { color: #1e8e3e; }
.stat-card.amber:hover .stat-value { color: #e37400; }
.stat-card.red:hover   .stat-value { color: #d93025; }

@keyframes countUp {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── CHART GRID ── */
.chart-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    flex: 1;
    min-height: 0;
}

.chart-card {
    background: #fff;
    border: 0.5px solid #e0e0e0;
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    min-height: 0;
    transition: box-shadow 0.22s ease, border-color 0.22s ease, transform 0.22s ease;
}

.chart-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.09);
    border-color: #d1d5db;
    transform: translateY(-2px);
}

.chart-title {
    font-size: 11.5px;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin: 0 0 10px;
    padding-bottom: 8px;
    border-bottom: 0.5px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 7px;
}

.chart-title i {
    font-size: 13px;
    opacity: 0.6;
}

.chart-wrap {
    flex: 1;
    position: relative;
    min-height: 0;
}

.chart-wrap canvas {
    position: absolute;
    inset: 0;
    width: 100% !important;
    height: 100% !important;
}
</style>

<div class="dash-wrap">

    {{-- STAT CARDS --}}
    <div class="stat-row">

        <div class="stat-card blue">
            <div class="stat-icon blue">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Mahasiswa</p>
                <p class="stat-value">{{ $mahasiswa }}</p>
            </div>
        </div>

        <div class="stat-card green">
            <div class="stat-icon green">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Dosen</p>
                <p class="stat-value">{{ $dosen }}</p>
            </div>
        </div>

        <div class="stat-card amber">
            <div class="stat-icon amber">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">Matakuliah</p>
                <p class="stat-value">{{ $matakuliah }}</p>
            </div>
        </div>

        <div class="stat-card red">
            <div class="stat-icon red">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <div class="stat-info">
                <p class="stat-label">KRS</p>
                <p class="stat-value">{{ $krs }}</p>
            </div>
        </div>

    </div>

    {{-- CHART GRID --}}
    <div class="chart-grid">

        <div class="chart-card">
            <p class="chart-title">
                <i class="fa-solid fa-chart-line"></i>
                Trend KRS per Semester
            </p>
            <div class="chart-wrap">
                <canvas id="angkatanChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <p class="chart-title">
                <i class="fa-solid fa-ranking-star"></i>
                Mata Kuliah Terpopuler
            </p>
            <div class="chart-wrap">
                <canvas id="mkChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <p class="chart-title">
                <i class="fa-solid fa-trophy"></i>
                Top Mahasiswa Aktif KRS
            </p>
            <div class="chart-wrap">
                <canvas id="topMahasiswaChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <p class="chart-title">
                <i class="fa-solid fa-chart-pie"></i>
                Distribusi Sistem
            </p>
            <div class="chart-wrap">
                <canvas id="pieChart"></canvas>
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const commonOpts = {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 700, easing: 'easeOutQuart' },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1f2937',
                padding: 8,
                cornerRadius: 6,
                titleFont: { size: 11 },
                bodyFont: { size: 12, weight: '600' }
            }
        }
    };

    const tickStyle = {
        color: '#9ca3af',
        font: { size: 10 }
    };

    const gridStyle = {
        color: 'rgba(0,0,0,0.05)',
        drawBorder: false
    };

    // ================= LINE CHART =================
    new Chart(document.getElementById('angkatanChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($angkatan_labels) !!},
            datasets: [{
                label: 'Jumlah Mahasiswa per Angkatan',
                data: {!! json_encode($angkatan_data) !!},
                borderColor: '#1967d2',
                backgroundColor: 'rgba(25,103,210,0.08)',
                borderWidth: 2,
                pointBackgroundColor: '#1967d2',
                pointRadius: 3,
                pointHoverRadius: 5,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...commonOpts,
            scales: {
                x: { ticks: tickStyle, grid: gridStyle },
                y: { ticks: tickStyle, grid: gridStyle }
            }
        }
    });

    // ================= MK CHART =================
    new Chart(document.getElementById('mkChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($mk_labels) !!},
            datasets: [{
                label: 'Mata Kuliah Terambil',
                data: {!! json_encode($mk_data) !!},
                backgroundColor: 'rgba(30,142,62,0.75)',
                hoverBackgroundColor: 'rgba(30,142,62,1)',
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            ...commonOpts,
            scales: {
                x: { ticks: { ...tickStyle, maxRotation: 30 }, grid: { display: false } },
                y: { ticks: tickStyle, grid: gridStyle }
            }
        }
    });

    // ================= TOP MAHASISWA =================
    new Chart(document.getElementById('topMahasiswaChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($top_mahasiswa_labels) !!},
            datasets: [{
                label: 'Aktivitas KRS',
                data: {!! json_encode($top_mahasiswa_data) !!},
                backgroundColor: 'rgba(227,116,0,0.75)',
                hoverBackgroundColor: 'rgba(227,116,0,1)',
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            ...commonOpts,
            indexAxis: 'y',
            scales: {
                x: { ticks: tickStyle, grid: gridStyle },
                y: { ticks: { ...tickStyle, maxRotation: 0 }, grid: { display: false } }
            }
        }
    });

    // ================= PIE =================
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Mahasiswa','Dosen','Matakuliah','KRS'],
            datasets: [{
                data: [
                    {{ $mahasiswa }},
                    {{ $dosen }},
                    {{ $matakuliah }},
                    {{ $krs }}
                ],
                backgroundColor: [
                    'rgba(25,103,210,0.8)',
                    'rgba(30,142,62,0.8)',
                    'rgba(227,116,0,0.8)',
                    'rgba(217,48,37,0.8)'
                ],
                hoverBackgroundColor: [
                    '#1967d2','#1e8e3e','#e37400','#d93025'
                ],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            ...commonOpts,
            cutout: '60%',
            plugins: {
                ...commonOpts.plugins,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        font: { size: 10 },
                        color: '#6b7280',
                        boxWidth: 10,
                        padding: 10,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });

});
</script>
@endpush