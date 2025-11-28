<?php include "../config/koneksi.php"; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penerima</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <h3 class="text-center mb-4">Tambah Penerima Baru</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Akun User Terkait</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                <?php
                $user_qry = mysqli_query($conn, "SELECT * FROM USER");
                while($u = mysqli_fetch_assoc($user_qry)){
                    echo "<option value='".$u['user_id']."'>".$u['nama']." (ID: ".$u['user_id'].")</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="2"></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Kelurahan</label>
                <input type="text" name="kelurahan" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Kategori Penerima</label>
            <input type="text" name="kategori_penerima" class="form-control" placeholder="Misal: Lansia, PKH, dll">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Penghasilan Bulanan (Rp)</label>
                <input type="number" name="penghasilan_bulanan" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Jumlah Tanggungan</label>
                <input type="number" name="jumlah_tanggungan" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Status Validasi</label>
                <select name="status_validasi" class="form-control">
                    <option>Menunggu</option>
                    <option>Valid</option>
                    <option>Tidak Valid</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Validasi</label>
                <input type="date" name="tanggal_validasi" value="<?= date('Y-m-d') ?>" class="form-control">
            </div>
        </div>

        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>

</div>

<?php
if(isset($_POST['simpan'])){
    $user_id = $_POST['user_id'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $kecamatan = $_POST['kecamatan'];
    $kelurahan = $_POST['kelurahan'];
    $kategori_penerima = $_POST['kategori_penerima'];
    $penghasilan_bulanan = $_POST['penghasilan_bulanan'];
    $jumlah_tanggungan = $_POST['jumlah_tanggungan'];
    $status_validasi = $_POST['status_validasi'];
    $tanggal_validasi = $_POST['tanggal_validasi'];

    $query = "INSERT INTO PENERIMA VALUES (NULL, '$user_id', '$nama_lengkap', '$tanggal_lahir', '$jenis_kelamin', '$alamat', '$kecamatan', '$kelurahan', '$kategori_penerima', '$penghasilan_bulanan', '$jumlah_tanggungan', '$status_validasi', '$tanggal_validasi')";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data penerima berhasil ditambahkan'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
}
?>

</body>
</html>