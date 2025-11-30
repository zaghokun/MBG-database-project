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

// Pastikan ID ada
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];

// Ambil data berdasarkan ID
$query = mysqli_query($koneksi_db, "SELECT * FROM PAKETBANTUAN WHERE paket_id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data paket tidak ditemukan");
}

// Proses Update Data
if (isset($_POST['update'])) {
    $nama_paket    = $_POST['nama_paket'];
    $deskripsi     = $_POST['deskripsi'];
    $jenis_bantuan = $_POST['jenis_bantuan'];
    $kalori_total  = $_POST['kalori_total'];
    $berat_total   = $_POST['berat_total'];
    $kadaluarsa    = $_POST['kadaluarsa'];
    $kuantitas     = $_POST['kuantitas'];

    $update = mysqli_query($koneksi_db, "UPDATE PAKETBANTUAN SET
                nama_paket='$nama_paket',
                deskripsi='$deskripsi',
                jenis_bantuan='$jenis_bantuan',
                kalori_total='$kalori_total',
                berat_total='$berat_total',
                kadaluarsa='$kadaluarsa',
                kuantitas='$kuantitas'
                WHERE paket_id='$id'
             ");

    if ($update) {
        // Redirect dengan pesan sukses (ditangani di index.php)
        echo "<script>alert('Paket berhasil diperbarui'); window.location='index.php?msg=updated';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update paket: " . mysqli_error($koneksi_db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Paket Bantuan</title>
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
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="Admin avatar" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBMiE0wUuuys5iOeo1ECHoqsh51gYGWWp1mG4BO4Th-47FvotdyKAbcihe3NNnHGB1N9gT1Sn1hKls5vgNtjLCicHpg5f6TXy5B3BwzX3ezH2goxAg7Go3wshEpUh_VmjiQ8Ep9bZbcBXQIepfYqWmNlfU_zPZr3MLp1mS1UtsdiWRYckmT_FX1W9yTknNNaqaxmH5iaF2e7ScVKtbaCBOzkh4fc2N6cyRpn495py7FYDvGGRk3vQdaAgfUdj0Uf9O8viZ3le_30g-Z");'></div>
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
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 dark:bg-primary/30" href="index.php">
            <span class="material-symbols-outlined text-primary dark:text-primary-300" style="font-variation-settings: 'FILL' 1, 'wght' 600;">inventory_2</span>
            <p class="text-primary dark:text-primary-300 text-sm font-medium leading-normal">Paket Bantuan</p>
        </a>
    </nav>
</aside>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex flex-wrap gap-2 mb-4">
            <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="index.php">Paket Bantuan</a>
            <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
            <span class="text-[#111418] dark:text-white text-sm font-medium">Edit Paket</span>
        </div>
        <p class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Edit Paket Bantuan</p>
    </div>

    <div class="bg-white dark:bg-background-dark dark:border dark:border-gray-700 p-8 rounded-xl shadow-sm">
        
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            
            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Nama Paket</p>
                    <input type="text" name="nama_paket" value="<?= htmlspecialchars($data['nama_paket']) ?>" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base" required />
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Deskripsi</p>
                    <textarea name="deskripsi" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 p-4 min-h-32 text-base" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Jenis Bantuan</p>
                    <select name="jenis_bantuan" class="form-select flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base">
                        <option value="Makanan" <?= ($data['jenis_bantuan'] == 'Makanan') ? 'selected' : '' ?>>Makanan</option>
                        <option value="Sembako" <?= ($data['jenis_bantuan'] == 'Sembako') ? 'selected' : '' ?>>Sembako</option>
                        <option value="Kesehatan" <?= ($data['jenis_bantuan'] == 'Kesehatan') ? 'selected' : '' ?>>Kesehatan</option>
                        <option value="Pendidikan" <?= ($data['jenis_bantuan'] == 'Pendidikan') ? 'selected' : '' ?>>Pendidikan</option>
                        <option value="Lainnya" <?= ($data['jenis_bantuan'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Kalori Total (kkal)</p>
                    <input type="number" name="kalori_total" value="<?= htmlspecialchars($data['kalori_total']) ?>" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base" required />
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Berat Total (Gram)</p>
                    <input type="number" name="berat_total" value="<?= htmlspecialchars($data['berat_total']) ?>" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base" required />
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Kuantitas</p>
                    <input type="number" name="kuantitas" value="<?= htmlspecialchars($data['kuantitas']) ?>" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base" required />
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Tanggal Kadaluarsa</p>
                    <input type="date" name="kadaluarsa" value="<?= htmlspecialchars($data['kadaluarsa']) ?>" class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base" required />
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