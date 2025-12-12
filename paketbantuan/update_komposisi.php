<?php
// 1. Integrasi Koneksi & Logic
include '../config/koneksi.php';
$koneksi_db = (isset($conn)) ? $conn : $koneksi;

if (!isset($_GET['id']) || !isset($_GET['detail_id'])) {
    header("Location: index.php");
    exit;
}

$paket_id = $_GET['id'];
$detail_id = $_GET['detail_id'];

// Ambil data detail lama dengan JOIN untuk info lengkap
$query_detail = mysqli_query($koneksi_db, "
    SELECT dp.*, p.nama_paket, i.nama_item, i.satuan 
    FROM DETAIL_PAKET dp
    JOIN PAKETBANTUAN p ON dp.paket_id = p.paket_id
    JOIN ITEM i ON dp.item_id = i.item_id
    WHERE dp.detail_id = '$detail_id'
");
$data = mysqli_fetch_assoc($query_detail);

if (!$data) {
    header("Location: komposisi.php?id=$paket_id");
    exit;
}

// Proses Update
if (isset($_POST['update'])) {
    $jumlah = $_POST['jumlah'];
    if (mysqli_query($koneksi_db, "UPDATE DETAIL_PAKET SET jumlah_per_paket='$jumlah' WHERE detail_id='$detail_id'")) {
        header("Location: komposisi.php?id=$paket_id&msg_type=success&msg=".urlencode("Jumlah berhasil diperbarui"));
        exit;
    } else {
        echo "<script>alert('Gagal update data');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Komposisi Paket</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
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
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 dark:bg-primary/30" href="index.php">
            <span class="material-symbols-outlined text-primary dark:text-primary-300" style="font-variation-settings: 'FILL' 1, 'wght' 600;">inventory_2</span>
            <p class="text-primary dark:text-primary-300 text-sm font-medium leading-normal">Paket Bantuan</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10 transition-colors" href="../item/index.php">
            <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">warehouse</span>
            <p class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal">Gudang Item</p>
        </a>
    </nav>
</aside>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex flex-wrap gap-2 mb-4">
            <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="index.php">Paket Bantuan</a>
            <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
            <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="komposisi.php?id=<?= $paket_id ?>">Komposisi</a>
            <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
            <span class="text-[#111418] dark:text-white text-sm font-medium">Edit Jumlah</span>
        </div>
        <p class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Edit Komposisi Paket</p>
        <p class="text-[#617589] dark:text-gray-400 mt-2 text-base">Ubah jumlah item yang dibutuhkan untuk paket ini.</p>
    </div>

    <div class="bg-white dark:bg-background-dark dark:border dark:border-gray-700 p-8 rounded-xl shadow-sm">
        
        <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase font-bold">Nama Paket</p>
                <p class="text-lg font-semibold text-[#111418] dark:text-white"><?= htmlspecialchars($data['nama_paket']) ?></p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-bold">Item yang Diedit</p>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">deployed_code</span>
                    <p class="text-lg font-semibold text-[#111418] dark:text-white">
                        <?= htmlspecialchars($data['nama_item']) ?> 
                        <span class="text-sm font-normal text-gray-500">(Satuan: <?= htmlspecialchars($data['satuan']) ?>)</span>
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" class="grid grid-cols-1 gap-y-6">
            
            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-base font-medium leading-normal pb-2">Jumlah Baru per Paket</p>
                    <input type="number" name="jumlah" step="0.01" min="0.01" value="<?= htmlspecialchars($data['jumlah_per_paket']) ?>" 
                           class="form-input flex w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 h-12 px-4 text-base focus:border-primary focus:ring-primary/50" required />
                </label>
            </div>

            <div class="flex justify-end gap-4 mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                <a href="komposisi.php?id=<?= $paket_id ?>" class="px-6 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Batal
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