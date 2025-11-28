<?php
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Distribusi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Data Distribusi</h2>

    <a href="update.php" class="btn btn-primary mb-3">+ Tambah Distribusi</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Paket</th>
                        <th>Penerima</th>
                        <th>Mitra</th>
                        <th>Tanggal Kirim</th>
                        <th>Tanggal Terima</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = "
                        SELECT d.*, 
                               p.nama_paket, 
                               r.nama_lengkap, 
                               m.nama_mitra
                        FROM distribusi d
                        LEFT JOIN paketbantuan p ON d.paket_id = p.paket_id
                        LEFT JOIN penerima r ON d.penerima_id = r.penerima_id
                        LEFT JOIN mitra m ON d.mitra_id = m.mitra_id
                    ";

                    $result = mysqli_query($conn, $query);

                    while($row = mysqli_fetch_assoc($result)){
                        echo "
                        <tr>
                            <td>$row[distribusi_id]</td>
                            <td>$row[nama_paket]</td>
                            <td>$row[nama_penerima]</td>
                            <td>$row[nama_mitra]</td>
                            <td>$row[tanggal_kirim]</td>
                            <td>$row[tanggal_terima]</td>
                            <td>$row[lokasi_pengiriman]</td>
                            <td>$row[status_pengiriman]</td>
                            <td>$row[bukti_pengiriman]</td>
                            <td>$row[catatan_petugas]</td>

                            <td>
                                <a href='edit.php?id=$row[distribusi_id]' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete.php?id=$row[distribusi_id]' class='btn btn-danger btn-sm'
                                    onclick=\"return confirm('Yakin hapus data ini?');\">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
