<?php 
include "../config/koneksi.php"; 
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM PENERIMA WHERE penerima_id=$id"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Penerima</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <h3 class="text-center mb-4">Edit Data Penerima</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Akun User Terkait</label>
            <select name="user_id" class="form-control" required>
                <?php
                $user_qry = mysqli_query($conn, "SELECT * FROM USER");
                while($u = mysqli_fetch_assoc($user_qry)){
                    $selected = ($u['user_id'] == $data['user_id']) ? "selected" : "";
                    echo "<option value='".$u['user_id']."' $selected>".$u['nama']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option <?= ($data['jenis_kelamin']=="Laki-laki")?"selected":"" ?>>Laki-laki</option>
                    <option <?= ($data['jenis_kelamin']=="Perempuan")?"selected":"" ?>>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="2"><?= $data['alamat'] ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" value="<?= $data['kecamatan'] ?>" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Kelurahan</label>
                <input type="text" name="kelurahan" value="<?= $data['kelurahan'] ?>" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Kategori Penerima</label>
            <input type="text" name="kategori_penerima" value="<?= $data['kategori_penerima'] ?>" class="form-control">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Penghasilan Bulanan (Rp)</label>
                <input type="number" name="penghasilan_bulanan" value="<?= $data['penghasilan_bulanan'] ?>" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Jumlah Tanggungan</label>
                <input type="number" name="jumlah_tanggungan" value="<?= $data['jumlah_tanggungan'] ?>" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Status Validasi</label>
                <select name="status_validasi" class="form-control">
                    <option <?= ($data['status_validasi']=="Menunggu")?"selected":"" ?>>Menunggu</option>
                    <option <?= ($data['status_validasi']=="Valid")?"selected":"" ?>>Valid</option>
                    <option <?= ($data['status_validasi']=="Tidak Valid")?"selected":"" ?>>Tidak Valid</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Validasi</label>
                <input type="date" name="tanggal_validasi" value="<?= $data['tanggal_validasi'] ?>" class="form-control">
            </div>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>

</div>

<?php
if(isset($_POST['update'])){
    mysqli_query($conn, "UPDATE PENERIMA SET 
        user_id='$_POST[user_id]',
        nama_lengkap='$_POST[nama_lengkap]',
        tanggal_lahir='$_POST[tanggal_lahir]',
        jenis_kelamin='$_POST[jenis_kelamin]',
        alamat='$_POST[alamat]',
        kecamatan='$_POST[kecamatan]',
        kelurahan='$_POST[kelurahan]',
        kategori_penerima='$_POST[kategori_penerima]',
        penghasilan_bulanan='$_POST[penghasilan_bulanan]',
        jumlah_tanggungan='$_POST[jumlah_tanggungan]',
        status_validasi='$_POST[status_validasi]',
        tanggal_validasi='$_POST[tanggal_validasi]'
        WHERE penerima_id=$id
    ");
    echo "<script>alert('Data penerima berhasil diupdate'); window.location='index.php';</script>";
}
?>

</body>
</html>