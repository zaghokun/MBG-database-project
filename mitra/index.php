<?php 
include "../config/koneksi.php"; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Mitra</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center mb-4">Data Mitra Kerjasama</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Mitra</a>
    <a href="../index.php" class="btn btn-secondary mb-3">Kembali</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Mitra</th>
                    <th>Jenis Mitra</th>
                    <th>Kontak Person</th>
                    <th>No HP</th>
                    <th>Wilayah Operasional</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM MITRA ORDER BY mitra_id DESC");
            while($row = mysqli_fetch_assoc($query)){
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $row['nama_mitra'] ?></td>
                    <td><?= $row['jenis_mitra'] ?></td>
                    <td><?= $row['kontak_person'] ?></td>
                    <td><?= $row['no_hp'] ?></td>
                    <td><?= $row['wilayah_operasional'] ?></td>
                    <td class="text-center">
                        <a href="update.php?id=<?= $row['mitra_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a onclick="return confirm('Hapus data mitra ini?')" href="delete.php?id=<?= $row['mitra_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>