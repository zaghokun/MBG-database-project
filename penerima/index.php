<?php 
include "../config/koneksi.php"; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Penerima</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center mb-4">Data Penerima Bantuan</h3>
    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Penerima</a>
    <a href="../index.php" class="btn btn-secondary mb-3">Kembali</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Kategori</th>
                    <th>Penghasilan</th>
                    <th>Jumlah Tanggungan</th> <th>Status Validasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM PENERIMA ORDER BY penerima_id DESC");
            while($row = mysqli_fetch_assoc($query)){
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $row['nama_lengkap'] ?></td>
                    <td><?= $row['alamat'] ?>, <?= $row['kelurahan'] ?></td>
                    <td><?= $row['kategori_penerima'] ?></td>
                    <td>Rp <?= number_format($row['penghasilan_bulanan'],0,',','.') ?></td>
                    
                    <td class="text-center"><?= $row['jumlah_tanggungan'] ?> Orang</td>
                    
                    <td>
                        <?php 
                        // Sedikit styling agar status terlihat lebih jelas (opsional)
                        if($row['status_validasi'] == 'Valid'){
                            echo '<span class="badge bg-success">Valid</span>';
                        } elseif($row['status_validasi'] == 'Tidak Valid'){
                            echo '<span class="badge bg-danger">Tidak Valid</span>';
                        } else {
                            echo '<span class="badge bg-warning text-dark">Menunggu</span>';
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <a href="update.php?id=<?= $row['penerima_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a onclick="return confirm('Hapus data penerima ini?')" href="delete.php?id=<?= $row['penerima_id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
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