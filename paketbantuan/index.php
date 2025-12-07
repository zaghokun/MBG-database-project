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
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Kelola Data Paket Bantuan</title>
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
          borderRadius: {
            "DEFAULT": "0.5rem",
            "lg": "1rem",
            "xl": "1.5rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>
<style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
    }
  </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex min-h-screen w-full flex-col group/design-root">
<div class="flex flex-grow">

<aside class="flex flex-col w-64 bg-white dark:bg-background-dark dark:border-r dark:border-gray-800 p-4 shrink-0 hidden lg:flex">
<div class="flex flex-col gap-4 h-full">
    <div class="flex items-center gap-3 px-2">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAxeuKUAQ_wskUxkEhnVs4z8j0aP1OtXvQ1P59r98qnhl-1npCmvnvR1x1KNUhTq_w8_FC6paJSnh8jyzUj8jWITi4ppZLLXP_iNUSvXZsBl3hPyf-0gwn0w8F4hMbsGv1bSa1Plg_NF2Kc3y2Oitzr_s41azmgiSu02N1jUw-MBAwrqU2d9V-o2mFMzJdEFD8bjW8Z9xFly3O5PXPjzy3SZmsO5ZSaRFJv9Hy0Jbj-vPKMqXXMwR01IXDWQzU058HaxLSuXwCz5dJt');"></div>
        <div class="flex flex-col">
            <h1 class="text-[#111418] dark:text-white text-base font-medium">Administrator</h1>
            <p class="text-[#617589] dark:text-gray-400 text-sm">admin@portal.com</p>
        </div>
    </div>
    <nav class="flex flex-col gap-2 mt-4 flex-grow">
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary dark:bg-primary/20" href="../index.php">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <p class="text-sm font-medium">Dashboard</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../mitra/index.php">
            <span class="material-symbols-outlined">handshake</span>
            <p class="text-sm font-medium">Mitra</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../user/index.php">
            <span class="material-symbols-outlined">person</span>
            <p class="text-sm font-medium">Pengguna</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../penerima/index.php">
            <span class="material-symbols-outlined">groups</span>
            <p class="text-sm font-medium">Penerima</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../paketbantuan/index.php">
            <span class="material-symbols-outlined">inventory_2</span>
            <p class="text-sm font-medium">Paket Bantuan</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../distribusi/index.php">
            <span class="material-symbols-outlined">local_shipping</span>
            <p class="text-sm font-medium">Distribusi</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../laporandata/index.php">
            <span class="material-symbols-outlined">description</span>
            <p class="text-sm font-medium">Laporan Data</p>
        </a>
    </nav>
    <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 text-sm font-bold">
        <span class="material-symbols-outlined mr-2">logout</span> Logout
    </button>
</div>
</aside>

<main class="flex-1 p-6 lg:p-10">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col sm:flex-row flex-wrap justify-between items-start sm:items-center gap-4 mb-6">
<div class="flex flex-col gap-1">
    <h1 class="text-[#111418] dark:text-white text-3xl font-black leading-tight tracking-[-0.033em]">Data Paket Bantuan</h1>
    <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola stok dan jenis bantuan yang tersedia.</p>
</div>
<a href="create.php" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-5 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined mr-2 text-base">add</span>
<span class="truncate">Tambah Paket</span>
</a>
</div>

<?php if (isset($_GET['msg'])) : ?>
    <div class="mb-6">
        <?php if ($_GET['msg'] == 'deleted') : ?>
            <div class="flex items-center p-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200" role="alert">
                <span class="material-symbols-outlined mr-2">check_circle</span>
                <span class="sr-only">Info</span>
                <div class="text-sm font-medium">Berhasil! Data paket berhasil dihapus.</div>
            </div>
        <?php elseif ($_GET['msg'] == 'error') : ?>
            <div class="flex items-center p-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200" role="alert">
                <span class="material-symbols-outlined mr-2">error</span>
                <span class="sr-only">Info</span>
                <div class="text-sm font-medium">Gagal! Data tidak dapat dihapus.</div>
            </div>
        <?php elseif ($_GET['msg'] == 'updated') : ?>
            <div class="flex items-center p-4 text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 border border-yellow-200" role="alert">
                <span class="material-symbols-outlined mr-2">info</span>
                <span class="sr-only">Info</span>
                <div class="text-sm font-medium">Berhasil! Data paket berhasil diperbarui.</div>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="bg-white dark:bg-background-dark rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-800">
<div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
<label class="flex flex-col w-full sm:w-80">
<div class="relative flex w-full flex-1 items-stretch rounded-lg h-10">
<div class="absolute inset-y-0 left-0 flex items-center pl-3">
<span class="material-symbols-outlined text-gray-400 dark:text-gray-500 text-xl">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] dark:text-gray-200 focus:outline-0 focus:ring-2 focus:ring-primary/50 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 h-full placeholder:text-gray-400 dark:placeholder:text-gray-500 pl-10 pr-4 text-sm font-normal leading-normal" placeholder="Cari berdasarkan nama paket..." value=""/>
</div>
</label>
</div>

<div class="overflow-x-auto">
<div class="min-w-full inline-block align-middle">
<table class="min-w-full">
<thead class="bg-gray-50 dark:bg-gray-800/30">
<tr>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">No</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Nama Paket</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Deskripsi</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Jenis Bantuan</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Kalori</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Berat</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Kadaluarsa</th>
<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Kuantitas</th>
<th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider" scope="col">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200 dark:divide-gray-800">

<?php
$no = 1;
$query = mysqli_query($koneksi_db, "SELECT * FROM PAKETBANTUAN ORDER BY paket_id DESC");

if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        // Logika untuk Warna Badge berdasarkan Jenis Bantuan
        $jenis = strtolower($row['jenis_bantuan']);
        $badge_class = "bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200"; // Default
        
        if (strpos($jenis, 'makanan') !== false || strpos($jenis, 'sembako') !== false) {
            $badge_class = "bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200";
        } elseif (strpos($jenis, 'kesehatan') !== false || strpos($jenis, 'medis') !== false) {
            $badge_class = "bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200";
        } elseif (strpos($jenis, 'kebersihan') !== false) {
            $badge_class = "bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200";
        } elseif (strpos($jenis, 'bayi') !== false || strpos($jenis, 'anak') !== false) {
            $badge_class = "bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-200";
        }
?>
    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= $no++ ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($row['nama_paket']) ?></td>
        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate"><?= htmlspecialchars($row['deskripsi']) ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm">
            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $badge_class ?>">
                <?= htmlspecialchars($row['jenis_bantuan']) ?>
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($row['kalori_total']) ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($row['berat_total']) ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($row['kadaluarsa']) ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium"><?= htmlspecialchars($row['kuantitas']) ?></td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
            <a href="update.php?id=<?= $row['paket_id'] ?>" class="inline-flex p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors" title="Edit">
                <span class="material-symbols-outlined text-base">edit</span>
            </a>
            <a href="delete.php?id=<?= $row['paket_id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data paket ini?')" class="inline-flex p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                <span class="material-symbols-outlined text-base">delete</span>
            </a>
        </td>
    </tr>
<?php 
    } // End While
} else {
?>
    <tr>
        <td colspan="9" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
            <span class="material-symbols-outlined text-4xl mb-2">inventory_2</span>
            <p>Belum ada data paket bantuan.</p>
        </td>
    </tr>
<?php } ?>

</tbody>
</table>
</div>
</div>
<div class="flex items-center justify-center p-4 border-t border-gray-200 dark:border-gray-800">
<p class="text-xs text-gray-400">Menampilkan semua data dari database</p>
</div>
</div>
</div>
</main>
</div>
</div>
</body>
</html>