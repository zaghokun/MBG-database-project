<?php include "../config/koneksi.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mitra</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <h3 class="text-center mb-4">Tambah Mitra Baru</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Akun User Penanggung Jawab</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                <?php
                $user_qry = mysqli_query($conn, "SELECT * FROM USER");
                while($u = mysqli_fetch_assoc($user_qry)){
                    echo "<option value='".$u['user_id']."'>".$u['nama']." (Role: ".$u['role'].")</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Mitra</label>
            <input type="text" name="nama_mitra" class="form-control" placeholder="Nama Perusahaan/Instansi" required>
        </div>

        <div class="mb-3">
            <label>Jenis Mitra</label>
            <input type="text" name="jenis_mitra" class="form-control" placeholder="Contoh: Supplier, Vendor, Donatur">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Kontak Person (PIC)</label>
                <input type="text" name="kontak_person" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Alamat Mitra</label>
            <textarea name="alamat_mitra" class="form-control" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label>Wilayah Operasional</label>
            <input type="text" name="wilayah_operasional" class="form-control" placeholder="Contoh: Jawa Tengah, Nasional, dll">
        </div>

        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>

</div>

<?php
if(isset($_POST['simpan'])){
    $user_id = $_POST['user_id'];
    $nama_mitra = $_POST['nama_mitra'];
    $jenis_mitra = $_POST['jenis_mitra'];
    $kontak_person = $_POST['kontak_person'];
    $no_hp = $_POST['no_hp'];
    $alamat_mitra = $_POST['alamat_mitra'];
    $wilayah_operasional = $_POST['wilayah_operasional'];

    $query = "INSERT INTO MITRA VALUES (NULL, '$user_id', '$nama_mitra', '$jenis_mitra', '$kontak_person', '$no_hp', '$alamat_mitra', '$wilayah_operasional')";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data mitra berhasil ditambahkan'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
}
?>

</body>
</html>