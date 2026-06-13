<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard SIAKAD</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/dashboard">SIAKAD</a>

        <div class="ms-auto">
            <a href="/dashboard" class="btn btn-outline-light btn-sm">Dashboard</a>
            <a href="/mahasiswa" class="btn btn-outline-light btn-sm">Mahasiswa</a>
            <a href="/dosen" class="btn btn-outline-light btn-sm">Dosen</a>
            <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>