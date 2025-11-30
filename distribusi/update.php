<?php
include '../config/koneksi.php';

// Ambil ID data yang akan diedit
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$distribusi_id = $_GET['id'];

// Ambil data lama
$data = mysqli_query($conn, "SELECT * FROM DISTRIBUSI WHERE distribusi_id = '$distribusi_id'");
$row = mysqli_fetch_assoc($data);

if (!$row) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $paket_id       = $_POST['paket_id'];
    $penerima_id    = $_POST['penerima_id'];
    $mitra_id       = $_POST['mitra_id'];
    $tanggal_kirim  = $_POST['tanggal_kirim'];
    $tanggal_terima = $_POST['tanggal_terima'];
    $lokasi         = $_POST['lokasi_pengiriman'];
    $status         = $_POST['status_pengiriman'];
    $catatan        = $_POST['catatan_petugas'];

    // Handle file
    $bukti_nama = $_FILES['bukti_pengiriman']['name'];

    if ($bukti_nama != "") {
        $tmp    = $_FILES['bukti_pengiriman']['tmp_name'];
        $folder = "../uploads/";

        $nama_baru = time() . "_" . $bukti_nama;
        move_uploaded_file($tmp, $folder . $nama_baru);

        // Hapus file lama jika ada
        if ($row['bukti_pengiriman'] != "" && file_exists($folder . $row['bukti_pengiriman'])) {
            unlink($folder . $row['bukti_pengiriman']);
        }

        $bukti_final = $nama_baru;
    } else {
        $bukti_final = $row['bukti_pengiriman']; // tetap pakai yang lama
    }

    $query = "UPDATE DISTRIBUSI SET 
                paket_id = '$paket_id',
                penerima_id = '$penerima_id',
                mitra_id = '$mitra_id',
                tanggal_kirim = '$tanggal_kirim',
                tanggal_terima = '$tanggal_terima',
                lokasi_pengiriman = '$lokasi',
                status_pengiriman = '$status',
                bukti_pengiriman = '$bukti_final',
                catatan_petugas = '$catatan'
              WHERE distribusi_id = '$distribusi_id'";

    mysqli_query($conn, $query);

    if ($query) {
        echo "<script>alert('Distribusi ditambahkan'); window.location='index.php';</script>";
        exit;
    } else {
        echo "Gagal tambah paket: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Distribusi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Edit Distribusi</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Paket Bantuan</label>
            <select name="paket_id" class="form-control" required>
                <option value="">-- Pilih Paket --</option>
                <?php
                $paket = mysqli_query($conn, "SELECT * FROM PAKETBANTUAN");
                while ($p = mysqli_fetch_assoc($paket)) {
                    $selected = ($p['paket_id'] == $row['paket_id']) ? "selected" : "";
                    echo "<option value='{$p['paket_id']}' $selected>{$p['nama_paket']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Penerima</label>
            <select name="penerima_id" class="form-control" required>
                <option value="">-- Pilih Penerima --</option>
                <?php
                $penerima = mysqli_query($conn, "SELECT * FROM PENERIMA");
                while ($p = mysqli_fetch_assoc($penerima)) {
                    $selected = ($p['penerima_id'] == $row['penerima_id']) ? "selected" : "";
                    echo "<option value='{$p['penerima_id']}' $selected>{$p['nama_lengkap']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Mitra</label>
            <select name="mitra_id" class="form-control" required>
                <option value="">-- Pilih Mitra --</option>
                <?php
                $mitra = mysqli_query($conn, "SELECT * FROM MITRA");
                while ($m = mysqli_fetch_assoc($mitra)) {
                    $selected = ($m['mitra_id'] == $row['mitra_id']) ? "selected" : "";
                    echo "<option value='{$m['mitra_id']}' $selected>{$m['nama_mitra']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Kirim</label>
            <input type="date" name="tanggal_kirim" value="<?= $row['tanggal_kirim'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tanggal Terima</label>
            <input type="date" name="tanggal_terima" value="<?= $row['tanggal_terima'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi Pengiriman</label>
            <input type="text" name="lokasi_pengiriman" value="<?= $row['lokasi_pengiriman'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status Pengiriman</label>
            <select name="status_pengiriman" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <?php
                $status_opsi = ["Dikemas","Dikirim","Diterima","Selesai","Gagal"];
                foreach ($status_opsi as $s) {
                    $selected = ($row['status_pengiriman'] == $s) ? "selected" : "";
                    echo "<option value='$s' $selected>$s</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Bukti Pengiriman (Foto)</label><br>
            <?php if ($row['bukti_pengiriman'] != "") { ?>
                <img src="../uploads/<?= $row['bukti_pengiriman'] ?>" width="150" class="mb-2"><br>
            <?php } ?>
            <input type="file" name="bukti_pengiriman" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label>Catatan Petugas</label>
            <textarea name="catatan_petugas" class="form-control" rows="3"><?= $row['catatan_petugas'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>

</div>

</body>
</html>
