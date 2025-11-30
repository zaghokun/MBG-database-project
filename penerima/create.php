<?php 
// 1. Integrasi Koneksi Database & Logika Simpan
include "../config/koneksi.php"; 

// Fix variabel koneksi
$koneksi_db = null;
if (isset($conn)) {
    $koneksi_db = $conn;
} elseif (isset($koneksi)) {
    $koneksi_db = $koneksi;
}

// Logika Simpan Data
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
    
    if(mysqli_query($koneksi_db, $query)){
        echo "<script>alert('Data penerima berhasil ditambahkan'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($koneksi_db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Tambah Penerima Baru</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
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
          fontFamily: { "display": ["Inter"] },
        },
      },
    }
</script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
<div class="relative flex min-h-screen w-full flex-col group/design-root">
<div class="flex flex-1">

<aside class="sticky top-0 h-screen w-64 shrink-0 bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-700 hidden lg:flex flex-col p-4">
    <div class="flex gap-3 items-center px-2 mb-6">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuALtgXvbJGt7K8jJR28J1mXfI4JDa03Vyf4wAo_p2_svT5lrM7duckJn5hspGAnzv-ETL1Og6w9hJIocWx1Wu55VBislHsKBgJZgAzMG-fHRYqgIUYinv5lhVhX5XKQ3c95s9HohYwy9PU_Ictv0V1nSyUfYiMxRXBdT6MKBQjDIfnJYLuiz_247vzaEAw7M_JVt4b2hq2m6RLh3tA_ftXVdI7L-ZgOjSpuxnLosaU3v58XwQgj_GaTwPi4bj0n8kq3QhuXY0NLtAqn");'></div>
        <div class="flex flex-col">
            <h1 class="text-[#111418] dark:text-white text-base font-medium">Administrator</h1>
            <p class="text-[#617589] dark:text-gray-400 text-sm">Panel Admin</p>
        </div>
    </div>
    <nav class="flex flex-col gap-1">
        <a href="../index.php" class="flex items-center gap-3 px-3 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm font-medium">Dashboard</span>
        </a>
        <a href="index.php" class="flex items-center gap-3 px-3 py-2 bg-primary/10 text-primary dark:bg-primary/20 rounded-lg">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">group</span>
            <span class="text-sm font-medium">Penerima</span>
        </a>
    </nav>
</aside>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    <div class="flex flex-wrap gap-2 mb-6">
        <a class="text-gray-500 dark:text-gray-400 text-sm hover:text-primary" href="index.php">Penerima</a>
        <span class="text-gray-500 dark:text-gray-400 text-sm">/</span>
        <span class="text-[#111418] dark:text-white text-sm font-medium">Tambah Baru</span>
    </div>

    <div class="flex justify-between gap-3 mb-8">
        <h1 class="text-[#111418] dark:text-white text-3xl font-black tracking-tight">Tambah Penerima Baru</h1>
    </div>

    <form method="POST" class="space-y-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-[#111418] dark:text-white text-lg font-bold px-6 pt-5 pb-2 border-b border-gray-200 dark:border-gray-700">Informasi Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                
                <div class="flex flex-col md:col-span-2">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Akun User Terkait</label>
                    <select name="user_id" class="form-select w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white h-12 px-4" required>
                        <option value="">-- Pilih User --</option>
                        <?php
                        $user_qry = mysqli_query($koneksi_db, "SELECT * FROM USER");
                        while($u = mysqli_fetch_assoc($user_qry)){
                            echo "<option value='".$u['user_id']."'>".$u['nama']." (ID: ".$u['user_id'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4" placeholder="Masukkan nama lengkap" required />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Kategori Penerima</label>
                    <input type="text" name="kategori_penerima" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4" placeholder="Misal: Lansia, PKH" />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4" />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-[#111418] dark:text-white text-lg font-bold px-6 pt-5 pb-2 border-b border-gray-200 dark:border-gray-700">Informasi Alamat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                
                <div class="flex flex-col md:col-span-2">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" class="form-textarea w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 p-3" placeholder="Nama jalan, RT/RW, No Rumah"></textarea>
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4" placeholder="Ketik nama kecamatan" />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Kelurahan/Desa</label>
                    <input type="text" name="kelurahan" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4" placeholder="Ketik nama kelurahan" />
                </div>

            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-[#111418] dark:text-white text-lg font-bold px-6 pt-5 pb-2 border-b border-gray-200 dark:border-gray-700">Data Ekonomi & Validasi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                
                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Penghasilan Bulanan (Rp)</label>
                    <input type="number" name="penghasilan_bulanan" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4" placeholder="0" />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Jumlah Tanggungan</label>
                    <input type="number" name="jumlah_tanggungan" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4" placeholder="0" />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Status Validasi</label>
                    <select name="status_validasi" class="form-select w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4">
                        <option value="Menunggu">Menunggu</option>
                        <option value="Valid">Valid</option>
                        <option value="Tidak Valid">Tidak Valid</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Tanggal Validasi</label>
                    <input type="date" name="tanggal_validasi" value="<?= date('Y-m-d') ?>" class="form-input w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 h-12 px-4" />
                </div>

            </div>
        </div>

        <div class="flex justify-end gap-4 pb-8">
            <a href="index.php" class="flex items-center justify-center gap-2 rounded-lg bg-gray-100 dark:bg-gray-700 px-6 py-3 text-base font-bold text-[#111418] dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Kembali
            </a>
            <button type="submit" name="simpan" class="flex items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-bold text-white hover:bg-primary/90 transition-colors">
                Simpan Data
            </button>
        </div>

    </form>
    </div>
</main>
</div>
</div>
</body>
</html>