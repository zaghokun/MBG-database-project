<?php 
include "../config/koneksi.php"; 
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM MITRA WHERE mitra_id=$id"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Mitra</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <h3 class="text-center mb-4">Edit Data Mitra</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Akun User Penanggung Jawab</label>
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
            <label>Nama Mitra</label>
            <input type="text" name="nama_mitra" value="<?= $data['nama_mitra'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Mitra</label>
            <input type="text" name="jenis_mitra" value="<?= $data['jenis_mitra'] ?>" class="form-control">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Kontak Person (PIC)</label>
                <input type="text" name="kontak_person" value="<?= $data['kontak_person'] ?>" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" value="<?= $data['no_hp'] ?>" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Alamat Mitra</label>
            <textarea name="alamat_mitra" class="form-control" rows="2"><?= $data['alamat_mitra'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Wilayah Operasional</label>
            <input type="text" name="wilayah_operasional" value="<?= $data['wilayah_operasional'] ?>" class="form-control">
        </div>

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>

</div>

<?php
if(isset($_POST['update'])){
    mysqli_query($conn, "UPDATE MITRA SET 
        user_id='$_POST[user_id]',
        nama_mitra='$_POST[nama_mitra]',
        jenis_mitra='$_POST[jenis_mitra]',
        kontak_person='$_POST[kontak_person]',
        no_hp='$_POST[no_hp]',
        alamat_mitra='$_POST[alamat_mitra]',
        wilayah_operasional='$_POST[wilayah_operasional]'
        WHERE mitra_id=$id
    ");
    echo "<script>alert('Data mitra berhasil diupdate'); window.location='index.php';</script>";
}
?>

</body>
</html>