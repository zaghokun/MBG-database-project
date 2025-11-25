<?php include "../config/koneksi.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center mb-4">Tambah User Baru</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <input type="text" name="role" class="form-control" placeholder="admin / operator / petugas">
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status Akun</label>
            <select name="status_akun" class="form-control">
                <option>Aktif</option>
                <option>Nonaktif</option>
            </select>
        </div>

        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>

</div>

<?php
if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $no_hp = $_POST['no_hp'];
    $tanggal_daftar = date('Y-m-d');
    $status_akun = $_POST['status_akun'];

    mysqli_query($conn, "INSERT INTO USER VALUES (NULL,'$nama','$email','$password','$role','$no_hp','$tanggal_daftar',NULL,'$status_akun')");
    echo "<script>alert('User berhasil ditambahkan'); window.location='index.php';</script>";
}
?>

</body>
</html>
