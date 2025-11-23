<?php include "config/koneksi.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Database Bantuan</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body style="background: #f0f2f5;">

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="m-0">Manajemen Database Bantuan</h3>
        </div>
        <div class="card-body">

            <div class="list-group">
                <a href="user/index.php" class="list-group-item list-group-item-action">Kelola User</a>
                <a href="penerima/index.php" class="list-group-item list-group-item-action">Kelola Penerima Bantuan</a>
                <a href="mitra/index.php" class="list-group-item list-group-item-action">Kelola Mitra Penyalur</a>
                <a href="paketbantuan/index.php" class="list-group-item list-group-item-action">Kelola Paket Bantuan</a>
                <a href="distribusi/index.php" class="list-group-item list-group-item-action">Kelola Distribusi</a>
                <a href="laporandata/index.php" class="list-group-item list-group-item-action">Kelola Laporan</a>
                <a href="dashboard/index.php" class="list-group-item list-group-item-action">Dashboard Ringkasan</a>
            </div>

        </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
