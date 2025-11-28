<?php
include '../config/koneksi.php';
?>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> Data paket berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'error') : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> Data tidak dapat dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated') : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> Data paket berhasil diperbarui.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Paket Bantuan</title>

    <!-- BOOTSTRAP 5 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Data Paket Bantuan</h2>
        <a href="create.php" class="btn btn-success">+ Tambah Paket</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Paket</th>
                        <th>Deskripsi</th>
                        <th>Jenis Bantuan</th>
                        <th>Kalori Total</th>
                        <th>Berat Total</th>
                        <th>Kadaluarsa</th>
                        <th>Kuantitas</th>
                        <th style="width: 130px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($conn, "SELECT * FROM paketbantuan");

                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$no++."</td>";
                        echo "<td>".$row['nama_paket']."</td>";
                        echo "<td>".$row['deskripsi']."</td>";
                        echo "<td>".$row['jenis_bantuan']."</td>";
                        echo "<td>".$row['kalori_total']."</td>";
                        echo "<td>".$row['berat_total']."</td>";
                        echo "<td>".$row['kadaluarsa']."</td>";
                        echo "<td>".$row['kuantitas']."</td>";

                        echo '<td>
                                <a href="update.php?id=' . $row['paket_id'] . '" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=' . $row['paket_id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Hapus data?\')">Hapus</a>
                              </td>';

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>Belum ada data</td></tr>";
                }
                ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<!-- BOOTSTRAP JS -->
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
