<!DOCTYPE html>
<html>
<head>
    <title>Cetak KRS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            border-radius: 4px;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-print {
            background: #0d6efd;
            color: white;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        @media print {
            .top-bar {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <a href="{{ route('user.krs.index') }}" class="btn btn-back">
        ← Kembali
    </a>

    <button onclick="window.print()" class="btn btn-print">
        🖨 Cetak
    </button>
</div>

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
            <th>Jam</th>
        </tr>
    </thead>
    <tbody>
        @foreach($krs as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->jadwal->mataKuliah->nama }}</td>
            <td>{{ $item->jadwal->mataKuliah->sks }}</td>
            <td>{{ $item->jadwal->hari }}</td>
            <td>{{ $item->jadwal->jam }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>