<?php 
// 1. Integrasi Koneksi Database & Ambil Data
include "../config/koneksi.php"; 

// Fix variabel koneksi
$koneksi_db = null;
if (isset($conn)) {
    $koneksi_db = $conn;
} elseif (isset($koneksi)) {
    $koneksi_db = $koneksi;
}

if (!$koneksi_db) {
    die("Error: Variabel koneksi database tidak ditemukan.");
}

// Ambil ID dari URL
$id = $_GET['id'];

// Proses Update Data
if(isset($_POST['update'])){
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

    $query_update = "UPDATE PENERIMA SET 
        user_id='$user_id',
        nama_lengkap='$nama_lengkap',
        tanggal_lahir='$tanggal_lahir',
        jenis_kelamin='$jenis_kelamin',
        alamat='$alamat',
        kecamatan='$kecamatan',
        kelurahan='$kelurahan',
        kategori_penerima='$kategori_penerima',
        penghasilan_bulanan='$penghasilan_bulanan',
        jumlah_tanggungan='$jumlah_tanggungan',
        status_validasi='$status_validasi',
        tanggal_validasi='$tanggal_validasi'
        WHERE penerima_id=$id";

    if(mysqli_query($koneksi_db, $query_update)){
        echo "<script>alert('Data penerima berhasil diupdate'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal update data: " . mysqli_error($koneksi_db) . "');</script>";
    }
}

// Ambil Data Penerima untuk ditampilkan di form
$query_data = mysqli_query($koneksi_db, "SELECT * FROM PENERIMA WHERE penerima_id=$id");
$data = mysqli_fetch_assoc($query_data);

// Cek apakah data ditemukan
if (!$data) {
    die("Data penerima tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Data Penerima</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#137fec",
                    "background-light": "#f6f7f8",
                    "background-dark": "#101922",
                },
                fontFamily: { "display": ["Inter", "sans-serif"] },
            },
        },
    }
</script>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
<div class="relative flex min-h-screen w-full">

<div class="sticky top-0 h-screen flex-shrink-0 bg-white dark:bg-background-dark dark:border-r dark:border-gray-800 p-4 shadow-sm w-64 hidden lg:block">
    <div class="flex h-full flex-col justify-between">
        <div class="flex flex-col gap-8">
            <div class="flex items-center gap-3 px-3 py-2">
                <span class="material-symbols-outlined text-primary text-3xl">grain</span>
                <h1 class="text-xl font-bold text-[#111418] dark:text-white">AidTrack</h1>
            </div>
            <div class="flex flex-col gap-2">
                <a href="../index.php" class="flex items-center gap-3 px-3 py-2 text-gray-500 dark:text-gray-400 hover:text-primary">
                    <span class="material-symbols-outlined text-2xl">dashboard</span>
                    <p class="text-sm font-medium">Dashboard</p>
                </a>
                <a href="index.php" class="flex items-center gap-3 rounded-lg bg-primary/10 px-3 py-2 text-primary">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">groups</span>
                    <p class="text-sm font-medium">Penerima</p>
                </a>
            </div>
        </div>
    </div>
</div>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    
    <div class="mb-8">
        <div class="flex flex-wrap gap-2 mb-4">
            <a class="text-gray-500 dark:text-gray-400 text-sm hover:text-primary" href="index.php">Penerima</a>
            <span class="text-gray-500 dark:text-gray-400 text-sm">/</span>
            <span class="text-[#111418] dark:text-white text-sm font-medium">Edit Data</span>
        </div>
        <p class="text-[#111418] dark:text-white text-3xl font-bold tracking-tight">Edit Data Penerima</p>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Perbarui informasi detail untuk penerima yang dipilih.</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-8 border border-gray-200 dark:border-gray-800">
        
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            
            <div class="col-span-1 md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Akun User Terkait</p>
                    <select name="user_id" class="form-select w-full rounded-lg text-[#111418] dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" required>
                        <?php
                        $user_qry = mysqli_query($koneksi_db, "SELECT * FROM USER");
                        while($u = mysqli_fetch_assoc($user_qry)){
                            $selected = ($u['user_id'] == $data['user_id']) ? "selected" : "";
                            echo "<option value='".$u['user_id']."' $selected>".$u['nama']." (ID: ".$u['user_id'].")</option>";
                        }
                        ?>
                    </select>
                </label>
            </div>

            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Nama Lengkap</p>
                    <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']) ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" required />
                </label>
            </div>

            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Tanggal Lahir</p>
                    <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($data['tanggal_lahir']) ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" />
                </label>
            </div>

            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Jenis Kelamin</p>
                    <select name="jenis_kelamin" class="form-select w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm">
                        <option value="Laki-laki" <?= ($data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </label>
            </div>

            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Kategori Penerima</p>
                    <input type="text" name="kategori_penerima" value="<?= htmlspecialchars($data['kategori_penerima']) ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" />
                </label>
            </div>

            <div class="col-span-1 md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Alamat Lengkap</p>
                    <textarea name="alamat" rows="3" class="form-textarea w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 text-sm"><?= htmlspecialchars($data['alamat']) ?></textarea>
                </label>
            </div>

            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Kecamatan</p>
                    <input type="text" name="kecamatan" value="<?= htmlspecialchars($data['kecamatan']) ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" />
                </label>
            </div>
            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Kelurahan</p>
                    <input type="text" name="kelurahan" value="<?= htmlspecialchars($data['kelurahan']) ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" />
                </label>
            </div>

            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Penghasilan Bulanan (Rp)</p>
                    <input type="number" name="penghasilan_bulanan" value="<?= htmlspecialchars($data['penghasilan_bulanan']) ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" />
                </label>
            </div>
            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Jumlah Tanggungan</p>
                    <input type="number" name="jumlah_tanggungan" value="<?= htmlspecialchars($data['jumlah_tanggungan']) ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" />
                </label>
            </div>

            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Status Validasi</p>
                    <select name="status_validasi" class="form-select w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm">
                        <option value="Menunggu" <?= ($data['status_validasi'] == 'Menunggu') ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Valid" <?= ($data['status_validasi'] == 'Valid') ? 'selected' : '' ?>>Valid</option>
                        <option value="Tidak Valid" <?= ($data['status_validasi'] == 'Tidak Valid') ? 'selected' : '' ?>>Tidak Valid</option>
                    </select>
                </label>
            </div>
            <div class="col-span-1">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Tanggal Validasi</p>
                    <input type="date" name="tanggal_validasi" value="<?= htmlspecialchars($data['tanggal_validasi']) ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-4 text-sm" />
                </label>
            </div>

            <div class="col-span-1 md:col-span-2 flex justify-end gap-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-sm font-semibold bg-gray-200/80 dark:bg-gray-700 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Kembali
                </a>
                <button type="submit" name="update" class="px-6 py-2.5 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors">
                    Simpan Perubahan
                </button>
            </div>

        </form>
        </div>
</div>
</main>
</div>
</body>
</html>