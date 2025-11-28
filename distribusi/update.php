<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $paket_id       = $_POST['paket_id'];
    $penerima_id    = $_POST['penerima_id'];
    $mitra_id       = $_POST['mitra_id'];
    $tanggal_kirim  = $_POST['tanggal_kirim'];
    $tanggal_terima = $_POST['tanggal_terima'];
    $lokasi         = $_POST['lokasi_pengiriman'];
    $status         = $_POST['status_pengiriman'];
    $catatan        = $_POST['catatan_petugas'];

    $bukti_nama = $_FILES['bukti_pengiriman']['name'];

    if ($bukti_nama != "") {
        $tmp   = $_FILES['bukti_pengiriman']['tmp_name'];
        $folder = "../uploads/";

        $nama_baru = time() . "_" . $bukti_nama; 
        move_uploaded_file($tmp, $folder . $nama_baru);

        $bukti_final = $nama_baru;
    } else {
        $bukti_final = "";
    }

    $query = "INSERT INTO distribusi 
                (paket_id, penerima_id, mitra_id, tanggal_kirim, tanggal_terima, 
                 lokasi_pengiriman, status_pengiriman, bukti_pengiriman, catatan_petugas)
              VALUES 
                ('$paket_id', '$penerima_id', '$mitra_id', '$tanggal_kirim', '$tanggal_terima',
                 '$lokasi', '$status', '$bukti_final', '$catatan')";

    mysqli_query($conn, $query);

    header("Location: index.php?add=success");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Distribusi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Tambah Distribusi</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Paket Bantuan</label>
            <select name="paket_id" class="form-control" required>
                <option value="">-- Pilih Paket --</option>
                <?php
                $paket = mysqli_query($conn, "SELECT * FROM paketbantuan");
                while ($p = mysqli_fetch_assoc($paket)) {
                    echo "<option value='{$p['paket_id']}'>{$p['nama_paket']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Penerima</label>
            <select name="penerima_id" class="form-control" required>
                <option value="">-- Pilih Penerima --</option>
                <?php
                $penerima = mysqli_query($conn, "SELECT * FROM penerima");
                while ($p = mysqli_fetch_assoc($penerima)) {
                    echo "<option value='{$p['penerima_id']}'>{$p['nama_penerima']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Mitra</label>
            <select name="mitra_id" class="form-control" required>
                <option value="">-- Pilih Mitra --</option>
                <?php
                $mitra = mysqli_query($conn, "SELECT * FROM mitra");
                while ($m = mysqli_fetch_assoc($mitra)) {
                    echo "<option value='{$m['mitra_id']}'>{$m['nama_mitra']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Kirim</label>
            <input type="date" name="tanggal_kirim" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tanggal Terima</label>
            <input type="date" name="tanggal_terima" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi Pengiriman</label>
            <input type="text" name="lokasi_pengiriman" class="form-control">
        </div>

        <div class="mb-3">
    <label class="form-label">Status Pengiriman</label>
    <select name="status_pengiriman" class="form-control" required>
        <option value="">-- Pilih Status --</option>
        <option value="Dikemas">Dikemas</option>
        <option value="Dikirim">Dikirim</option>
        <option value="Diterima">Diterima</option>
        <option value="Selesai">Selesai</option>
        <option value="Gagal">Gagal</option>
    </select>
    </div>


        <div class="mb-3">
            <label class="form-label">Bukti Pengiriman (Foto)</label>
            <input type="file" name="bukti_pengiriman" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label>Catatan Petugas</label>
            <textarea name="catatan_petugas" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>

</div>

</body>
</html>
