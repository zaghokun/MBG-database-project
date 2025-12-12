<?php
// 1. Integrasi Koneksi Database & Ambil Data
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

// Pastikan ID ada
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];

// Ambil data berdasarkan ID
$query = mysqli_query($koneksi_db, "SELECT * FROM ITEM WHERE item_id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data item tidak ditemukan");
}

// Proses Update Data
if (isset($_POST['update'])) {
    $nama_item = $_POST['nama_item'];
    $satuan    = $_POST['satuan'];
    $stok      = $_POST['stok_gudang'];

    $update = mysqli_query($koneksi_db, "UPDATE ITEM SET
                nama_item='$nama_item',
                satuan='$satuan',
                stok_gudang='$stok'
                WHERE item_id='$id'
             ");

    if ($update) {
        echo "<script>alert('Item berhasil diperbarui'); window.location='index.php?msg=updated';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update item: " . mysqli_error($koneksi_db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Data Item</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,0..200" rel="stylesheet"/>
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
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
<div class="relative flex min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="flex flex-grow">

<aside class="flex flex-col w-64 bg-white dark:bg-background-dark dark:border-r dark:border-gray-700 p-4 transition-all duration-300 hidden lg:flex">
    <div class="flex items-center gap-3 mb-8 p-2">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="Admin avatar" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBMSuCqzhobnCaUbEdoyM6VHDrDCQEgxACBAfH9QUpSH_lbrV_l35SU0oDYtAaBXP9bU86jq3JTJgM-j0kEPcQGj7e13gN5pisyR3bTld18qN3FILkKRpLy6-80K7Bb-Fl9FeUfeuZv3x2IFPFw45TDPeMDBljZX0KiGKZ1cFPn7H78v6a-MGklw38yvyaXS19VttnaFCa71J8q6xdbGkzoeSHN_ZihCv_DGyHtcnoTN7GIw3vVTFOQxqoXKbQosAJjVXOLaf08Fiwv");'></div>
        <div class="flex flex-col">
            <h1 class="text-[#111418] dark:text-white text-base font-medium leading-normal">Administrator</h1>
            <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">admin@portal.com</p>
        </div>
    </div>
    <nav class="flex flex-col gap-2 flex-1">
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10 transition-colors" href="../index.php">
            <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">dashboard</span>
            <p class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal">Dashboard</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10 transition-colors" href="../paketbantuan/index.php">
            <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">inventory_2</span>
            <p class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal">Paket Bantuan</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 dark:bg-primary/30" href="index.php">
            <span class="material-symbols-outlined text-primary dark:text-primary-300" style="font-variation-settings: 'FILL' 1, 'wght' 600;">warehouse</span>
            <p class="text-primary dark:text-primary-300 text-sm font-medium leading-normal">Gudang Item</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10 transition-colors" href="../distribusi/index.php">
            <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">local_shipping</span>
            <p class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal">Distribusi</p>
        </a>
    </nav>
</aside>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex flex-wrap gap-2 mb-4">
            <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="index.php">Gudang Item</a>
            <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
            <span class="text-[#111418] dark:text-white text-sm font-medium">Edit Item</span>
        </div>
        <p class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Edit Data Item</p>
    </div>

    <div class="bg-white dark:bg-background-dark dark:border dark:border-gray-700 p-8 rounded-xl shadow-sm">
        
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            
            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Nama Item</p>
                    <input type="text" name="nama_item" value="<?= htmlspecialchars($data['nama_item']) ?>" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base" required />
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Satuan (Kg/Liter/Pcs)</p>
                    <input type="text" name="satuan" value="<?= htmlspecialchars($data['satuan']) ?>" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base" required />
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Stok Gudang</p>
                    <input type="number" name="stok_gudang" value="<?= htmlspecialchars($data['stok_gudang']) ?>" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base" required />
                </label>
            </div>

            <div class="md:col-span-2 flex justify-end gap-4 mt-6">
                <a href="index.php" class="px-6 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Kembali
                </a>
                <button type="submit" name="update" class="px-6 py-3 rounded-lg bg-primary text-white text-sm font-medium hover:bg-primary/90 transition-colors">
                    Simpan Perubahan
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