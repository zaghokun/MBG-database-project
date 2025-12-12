<?php
// 1. Integrasi Koneksi Database
include '../config/koneksi.php';

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

// 2. Logika Simpan Data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_paket'];
    $deskripsi = $_POST['deskripsi'];
    $jenis = $_POST['jenis_bantuan'];
    $kalori = $_POST['kalori_total'];
    $berat = $_POST['berat_total'];
    $kadaluarsa = $_POST['kadaluarsa'];
    $kuantitas = $_POST['kuantitas'];

    $query = "INSERT INTO PAKETBANTUAN
        (nama_paket, deskripsi, jenis_bantuan, kalori_total, berat_total, kadaluarsa, kuantitas)
        VALUES ('$nama', '$deskripsi', '$jenis', '$kalori', '$berat', '$kadaluarsa', '$kuantitas')";

    if (mysqli_query($koneksi_db, $query)) {
        // Ambil ID paket yang baru saja dibuat
        $new_paket_id = mysqli_insert_id($koneksi_db);
        
        // Redirect langsung ke halaman Komposisi untuk isi item
        echo "<script>
                alert('Paket berhasil dibuat! Silakan tambahkan isi paketnya.'); 
                window.location='komposisi.php?id=$new_paket_id';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal tambah paket: " . mysqli_error($koneksi_db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Tambah Paket Bantuan</title>
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
          fontFamily: {
            "display": ["Inter", "sans-serif"]
          },
          borderRadius: { "DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px" },
        },
      },
    }
</script>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="flex min-h-screen">

<aside class="w-64 shrink-0 bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between hidden lg:flex">
<div class="p-4">
    <div class="flex items-center gap-3 mb-6 p-2">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="Admin user avatar" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBMSuCqzhobnCaUbEdoyM6VHDrDCQEgxACBAfH9QUpSH_lbrV_l35SU0oDYtAaBXP9bU86jq3JTJgM-j0kEPcQGj7e13gN5pisyR3bTld18qN3FILkKRpLy6-80K7Bb-Fl9FeUfeuZv3x2IFPFw45TDPeMDBljZX0KiGKZ1cFPn7H78v6a-MGklw38yvyaXS19VttnaFCa71J8q6xdbGkzoeSHN_ZihCv_DGyHtcnoTN7GIw3vVTFOQxqoXKbQosAJjVXOLaf08Fiwv");'></div>
        <div class="flex flex-col">
            <h1 class="text-gray-900 dark:text-white text-base font-medium leading-normal">Administrator</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal">admin@portal.com</p>
        </div>
    </div>
    <nav class="flex flex-col gap-2">
        <a class="flex items-center gap-3 px-3 py-2 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../index.php">
            <span class="material-symbols-outlined">dashboard</span>
            <p class="text-sm font-medium leading-normal">Dashboard</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary" href="index.php">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
            <p class="text-sm font-medium leading-normal">Paket Bantuan</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../item/index.php">
            <span class="material-symbols-outlined">warehouse</span>
            <p class="text-sm font-medium leading-normal">Gudang Item</p>
        </a>
    </nav>
</div>
<div class="p-4 border-t border-gray-200 dark:border-gray-800">
    <nav class="flex flex-col gap-1">
        <a class="flex items-center gap-3 px-3 py-2 rounded text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="#">
            <span class="material-symbols-outlined">logout</span>
            <p class="text-sm font-medium leading-normal">Logout</p>
        </a>
    </nav>
</div>
</aside>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex flex-wrap gap-2 mb-4">
            <a class="text-gray-500 dark:text-gray-400 text-sm hover:text-primary" href="index.php">Paket Bantuan</a>
            <span class="text-gray-500 dark:text-gray-400 text-sm">/</span>
            <span class="text-[#111418] dark:text-white text-sm font-medium">Tambah Baru</span>
        </div>
        <p class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Tambah Paket Bantuan</p>
        <p class="text-gray-500 dark:text-gray-400 mt-2">Langkah 1: Buat Data Paket Utama. Setelah ini, Anda akan diarahkan untuk mengisi komposisi item.</p>
    </div>

    <div class="bg-white dark:bg-gray-900/50 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
        
        <form method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label class="flex flex-col">
                        <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Nama Paket*</p>
                        <input type="text" name="nama_paket" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800/50 h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="Contoh: Paket Sembako Esensial" required />
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="flex flex-col">
                        <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Deskripsi*</p>
                        <textarea name="deskripsi" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800/50 p-4 min-h-32 focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="Masukkan deskripsi lengkap tentang isi paket"></textarea>
                    </label>
                </div>

                <div>
                    <label class="flex flex-col">
                        <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Jenis Bantuan*</p>
                        <select name="jenis_bantuan" class="form-select flex w-full rounded-lg text-[#111418] dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800/50 h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary">
                            <option value="">Pilih jenis bantuan</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Sembako">Sembako</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Pendidikan">Pendidikan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </label>
                </div>

                <div>
                    <label class="flex flex-col">
                        <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Kuantitas*</p>
                        <input type="number" name="kuantitas" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800/50 h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="0" required />
                    </label>
                </div>

                <div>
                    <label class="flex flex-col">
                        <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Kalori Total (kkal)</p>
                        <input type="number" name="kalori_total" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800/50 h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="2500" />
                    </label>
                </div>

                <div>
                    <label class="flex flex-col">
                        <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Berat Total (Gram)</p>
                        <input type="number" name="berat_total" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800/50 h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="5000" />
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="flex flex-col">
                        <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Tanggal Kadaluarsa</p>
                        <input type="date" name="kadaluarsa" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800/50 h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary" />
                    </label>
                </div>
            </div>

            <div class="flex justify-end items-center gap-4 pt-4 border-t border-gray-200 dark:border-gray-800">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-base font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-700 transition-colors">
                    Kembali
                </a>
                <button type="submit" name="submit" class="px-6 py-2.5 rounded-lg text-base font-semibold text-white bg-primary hover:bg-primary/90 transition-colors">
                    Simpan & Lanjut ke Isi Paket &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
</main>
</div>
</div>
</body>
</html>