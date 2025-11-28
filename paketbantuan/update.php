<?php
include '../config/koneksi.php';

// Pastikan ID ada
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan";
    exit;
}

$id = $_GET['id'];

// Ambil data berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM paketbantuan WHERE paket_id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}

// Jika tombol update ditekan
if (isset($_POST['update'])) {
    $nama_paket    = $_POST['nama_paket'];
    $deskripsi     = $_POST['deskripsi'];
    $jenis_bantuan = $_POST['jenis_bantuan'];
    $kalori_total  = $_POST['kalori_total'];
    $berat_total   = $_POST['berat_total'];
    $kadaluarsa    = $_POST['kadaluarsa'];
    $kuantitas     = $_POST['kuantitas'];

    $update = mysqli_query($conn, "UPDATE paketbantuan SET
                nama_paket='$nama_paket',
                deskripsi='$deskripsi',
                jenis_bantuan='$jenis_bantuan',
                kalori_total='$kalori_total',
                berat_total='$berat_total',
                kadaluarsa='$kadaluarsa',
                kuantitas='$kuantitas'
                WHERE paket_id='$id'
             ");

    if ($update) {
        header("Location: index.php?msg=updated");
        exit;
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Paket Bantuan</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="card shadow p-4">
        <h3 class="mb-3">Edit Paket Bantuan</h3>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nama Paket</label>
                <input type="text" class="form-control" name="nama_paket" value="<?= $data['nama_paket']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" required><?= $data['deskripsi']; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Bantuan</label>
                <input type="text" class="form-control" name="jenis_bantuan" value="<?= $data['jenis_bantuan']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kalori Total</label>
                <input type="number" class="form-control" name="kalori_total" value="<?= $data['kalori_total']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Berat Total</label>
                <input type="number" class="form-control" name="berat_total" value="<?= $data['berat_total']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kadaluarsa</label>
                <input type="date" class="form-control" name="kadaluarsa" value="<?= $data['kadaluarsa']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kuantitas</label>
                <input type="number" class="form-control" name="kuantitas" value="<?= $data['kuantitas']; ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update Paket</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>

        </form>
    </div>
</div>

</body>
</html>
