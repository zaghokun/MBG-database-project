<?php
include '../config/koneksi.php';

if (isset($_POST['submit'])) {

    $nama = $_POST['nama_paket'];
    $deskripsi = $_POST['deskripsi'];
    $jenis = $_POST['jenis_bantuan'];
    $kalori = $_POST['kalori_total'];
    $berat = $_POST['berat_total'];
    $kadaluarsa = $_POST['kadaluarsa'];
    $kuantitas = $_POST['kuantitas'];

    $insert = mysqli_query($conn, "INSERT INTO PAKETBANTUAN
        (nama_paket, deskripsi, jenis_bantuan, kalori_total, berat_total, kadaluarsa, kuantitas)
        VALUES ('$nama', '$deskripsi', '$jenis', '$kalori', '$berat', '$kadaluarsa', '$kuantitas')");

    if ($insert) {
        echo "<script>alert('Paket berhasil ditambahkan'); window.location='index.php';</script>";
        exit;
    } else {
        echo "Gagal tambah paket: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Paket Bantuan</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Tambah Paket Bantuan</h4>
        </div>

        <div class="card-body">

            <form method="post" action="">

                <div class="mb-3">
                    <label class="form-label">Nama Paket</label>
                    <input type="text" name="nama_paket" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Bantuan</label>
                    <input type="text" name="jenis_bantuan" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kalori Total</label>
                    <input type="number" name="kalori_total" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Berat Total (gram)</label>
                    <input type="number" name="berat_total" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kadaluarsa</label>
                    <input type="date" name="kadaluarsa" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Kuantitas</label>
                    <input type="number" name="kuantitas" class="form-control">
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100">
                    ➕ Tambah Paket
                </button>

            </form>

        </div>
    </div>

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-secondary">⬅ Kembali ke Daftar Paket</a>
    </div>
</div>

</body>
</html>
