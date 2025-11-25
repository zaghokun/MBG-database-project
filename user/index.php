<?php 
include "../config/koneksi.php"; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola User</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center mb-4">Data User</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah User</a>
    <a href="../index.php" class="btn btn-secondary mb-3">Kembali</a>

    <table class="table table-bordered table-hover">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>No HP</th>
                <th>Status Akun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>

        <?php
        $no = 1;
        $query = mysqli_query($conn, "SELECT * FROM USER ORDER BY user_id DESC");
        while($row = mysqli_fetch_assoc($query)){
        ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['role'] ?></td>
                <td><?= $row['no_hp'] ?></td>
                <td><?= $row['status_akun'] ?></td>
                <td class="text-center">
                    <a href="update.php?id=<?= $row['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a onclick="return confirm('Hapus user ini?')" href="delete.php?id=<?= $row['user_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
