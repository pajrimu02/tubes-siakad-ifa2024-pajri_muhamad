<!DOCTYPE html>
<html>
<head>
    <title>Cetak KRS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    body {
        font-family: 'Inter', sans-serif;
        background: #f8fafc;
        padding: 20px;
        color: #111827;
    }

    /* TOP BAR */
    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .btn {
        padding: 10px 14px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }

    .btn-back {
        background: #fff;
        border: 1px solid #e5e7eb;
        color: #374151;
    }

    .btn-back:hover {
        background: #f3f4f6;
    }

    .btn-print {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        box-shadow: 0 3px 12px rgba(99,102,241,0.3);
    }

    .btn-print:hover {
        transform: translateY(-2px);
    }

    /* CARD */
    .card {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    /* HEADER */
    .header {
        text-align: center;
        padding: 24px;
        border-bottom: 1px solid #f1f5f9;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
    }

    .header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .header h3 {
        margin: 6px 0 0;
        font-size: 16px;
        font-weight: 600;
    }

    .header p {
        margin: 4px 0 0;
        font-size: 12px;
        opacity: 0.9;
    }

    /* TABLE */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: center;
        font-size: 13px;
    }

    th {
        background: #f8fafc;
        font-weight: 700;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        border-bottom: 1px solid #f1f5f9;
    }

    tr:hover td {
        background: #fafbff;
    }

    /* PRINT */
    @media print {
        body {
            background: white;
            padding: 0;
        }

        .top-bar {
            display: none;
        }

        .card {
            box-shadow: none;
            border: none;
        }
    }
    </style>
</head>

<body>

<div class="top-bar">
    <a href="{{ route('user.krs.index') }}" class="btn btn-back">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>

    <button onclick="window.print()" class="btn btn-print">
        <i class="fa fa-print"></i> Cetak
    </button>
</div>

<div class="card">

    <div class="header">
        <h2>KARTU RENCANA STUDI</h2>
        <h3>{{ $mahasiswa->nama }}</h3>
        <p>NIM: {{ $mahasiswa->nim }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Hari</th>
            
            </tr>
        </thead>

        <tbody>
            @foreach($krs as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->jadwal->matakuliah->nama_mk }}</td>
                <td>{{ $item->jadwal->matakuliah->sks }}</td>
                <td>{{ $item->jadwal->hari }}</td>
                 
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>