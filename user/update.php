<?php 
include "../config/koneksi.php"; 
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM USER WHERE user_id=$id"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center mb-4">Edit User</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <input type="text" name="role" value="<?= $data['role'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" value="<?= $data['no_hp'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status Akun</label>
            <select name="status_akun" class="form-control">
                <option <?= ($data['status_akun']=="Aktif")?"selected":"" ?>>Aktif</option>
                <option <?= ($data['status_akun']=="Nonaktif")?"selected":"" ?>>Nonaktif</option>
            </select>
        </div>

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>

</div>

<?php
if(isset($_POST['update'])){
    mysqli_query($conn, "UPDATE USER SET 
        nama='$_POST[nama]',
        email='$_POST[email]',
        role='$_POST[role]',
        no_hp='$_POST[no_hp]',
        status_akun='$_POST[status_akun]'
        WHERE user_id=$id
    ");
    echo "<script>alert('Data user berhasil diupdate'); window.location='index.php';</script>";
}
?>

</body>
</html>
