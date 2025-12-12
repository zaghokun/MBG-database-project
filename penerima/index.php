<?php 
// 1. Integrasi Koneksi Database
include "../config/koneksi.php"; 

// Fix variabel koneksi (kompatibilitas $conn vs $koneksi)
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
<title>Kelola Penerima Bantuan</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
      }
    </style>
<script id="tailwind-config">
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
            borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
          },
        },
      }
    </script>
</head>
<body class="font-display">
<div class="relative flex h-auto min-h-screen w-full flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden">
<div class="flex min-h-screen">

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
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../item/index.php">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">warehouse</span>
            <p class="text-sm font-medium">Gudang Item</p>
        </a>
    </nav>
    <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 text-sm font-bold">
        <span class="material-symbols-outlined mr-2">logout</span> Logout
    </button>
</div>
</aside>

<main class="flex-1 flex flex-col p-6 lg:p-8">
<div class="w-full max-w-7xl mx-auto">
<div class="flex flex-wrap justify-between items-center gap-4 mb-6">
<div class="flex flex-col gap-1">
    <p class="text-gray-900 dark:text-white text-3xl font-bold leading-tight tracking-tight">Data Penerima Bantuan</p>
    <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola data warga penerima manfaat bantuan sosial.</p>
</div>
<a href="create.php" class="flex min-w-[84px] cursor-pointer items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal shadow-sm hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined text-xl">add</span>
<span class="truncate">Tambah Penerima</span>
</a>
</div>

<div class="mb-4">
<div class="flex flex-col sm:flex-row gap-4 items-center">
<div class="flex-1 w-full">
<label class="flex flex-col min-w-40 h-12 w-full">
<div class="flex w-full flex-1 items-stretch rounded-lg h-full">
<div class="text-gray-500 dark:text-gray-400 flex bg-white dark:bg-gray-800/50 items-center justify-center pl-4 rounded-l-lg border border-gray-200 dark:border-gray-700 border-r-0">
<span class="material-symbols-outlined text-xl">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/50 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 border-l-0 text-sm font-normal leading-normal" placeholder="Cari berdasarkan nama..." value=""/>
</div>
</label>
</div>
<div class="flex gap-3 self-start sm:self-center">
<button class="flex h-12 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 px-4">
<p class="text-gray-900 dark:text-white text-sm font-medium leading-normal">Kategori</p>
<span class="material-symbols-outlined text-xl text-gray-500 dark:text-gray-400">expand_more</span>
</button>
</div>
</div>
</div>

<div class="bg-white dark:bg-background-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
<thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50">
<tr>
<th class="px-6 py-3 font-semibold" scope="col">Nama Lengkap</th>
<th class="px-6 py-3 font-semibold" scope="col">Alamat</th>
<th class="px-6 py-3 font-semibold" scope="col">Kategori</th>
<th class="px-6 py-3 font-semibold" scope="col">Penghasilan</th>
<th class="px-6 py-3 font-semibold text-center" scope="col">Tanggungan</th>
<th class="px-6 py-3 font-semibold text-center" scope="col">Status</th>
<th class="px-6 py-3 font-semibold text-right" scope="col">Aksi</th>
</tr>
</thead>
<tbody>

<?php
// Query Database
$query = mysqli_query($koneksi_db, "SELECT * FROM PENERIMA ORDER BY penerima_id DESC");

if (mysqli_num_rows($query) > 0) {
    while($row = mysqli_fetch_assoc($query)){
        // Logika Status Validasi ke Tailwind Class
        $status_validasi = $row['status_validasi'];
        $badge_class = "";
        $status_label = $status_validasi;
        $icon = "";

        if($status_validasi == 'Valid'){
            $badge_class = "bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300";
            $icon = "check_circle";
        } elseif($status_validasi == 'Tidak Valid'){
            $badge_class = "bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300";
            $status_label = "Ditolak"; // Label kustom sesuai tampilan
            $icon = "cancel";
        } else {
            $badge_class = "bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300";
            $status_label = "Proses";
            $icon = "hourglass_top";
        }
?>
    <tr class="bg-white dark:bg-background-dark border-b dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
        <td class="px-6 py-4">
            <div class="font-medium text-gray-900 dark:text-white whitespace-nowrap"><?= htmlspecialchars($row['nama_lengkap']) ?></div>
            <div class="text-xs text-gray-500 mt-0.5">ID: <?= $row['penerima_id'] ?></div>
        </td>
        <td class="px-6 py-4">
            <div class="line-clamp-1" title="<?= htmlspecialchars($row['alamat']) ?>"><?= htmlspecialchars($row['alamat']) ?></div>
            <div class="text-xs text-gray-500 mt-0.5">
                <?= htmlspecialchars($row['kelurahan']) ?>, <?= htmlspecialchars($row['kecamatan']) ?>
            </div>
        </td>
        <td class="px-6 py-4">
            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                <?= htmlspecialchars($row['kategori_penerima']) ?>
            </span>
        </td>
        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
            Rp <?= number_format($row['penghasilan_bulanan'], 0, ',', '.') ?>
        </td>
        <td class="px-6 py-4 text-center">
            <div class="inline-flex items-center gap-1 text-gray-600 dark:text-gray-300">
                 <span class="material-symbols-outlined text-base">groups</span>
                 <?= $row['jumlah_tanggungan'] ?>
            </div>
        </td>
        <td class="px-6 py-4 text-center">
            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full <?= $badge_class ?>">
                <span class="material-symbols-outlined text-[14px]"><?= $icon ?></span>
                <?= $status_label ?>
            </span>
        </td>
        <td class="px-6 py-4 text-right">
            <div class="flex items-center justify-end gap-2">
                <a href="update.php?id=<?= $row['penerima_id'] ?>" class="p-2 text-gray-500 hover:text-primary dark:hover:text-primary rounded-full hover:bg-primary/10 transition-colors" title="Edit">
                    <span class="material-symbols-outlined text-xl">edit</span>
                </a>
                <a href="delete.php?id=<?= $row['penerima_id'] ?>" onclick="return confirm('Hapus data penerima ini?')" class="p-2 text-gray-500 hover:text-red-500 dark:hover:text-red-500 rounded-full hover:bg-red-500/10 transition-colors" title="Hapus">
                    <span class="material-symbols-outlined text-xl">delete</span>
                </a>
            </div>
        </td>
    </tr>
<?php 
    } // End While
} else {
?>
    <tr>
        <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
            <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
            <p>Belum ada data penerima bantuan.</p>
        </td>
    </tr>
<?php } ?>

</tbody>
</table>
</div>

<nav aria-label="Table navigation" class="flex items-center justify-between p-4 border-t border-gray-200 dark:border-gray-800">
<span class="text-sm font-normal text-gray-500 dark:text-gray-400">Menampilkan data database</span>
<ul class="inline-flex items-center -space-x-px">
<li>
<a class="block px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" href="#">
<span class="sr-only">Previous</span>
<span class="material-symbols-outlined text-lg">chevron_left</span>
</a>
</li>
<li>
<a class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" href="#">
<span class="sr-only">Next</span>
<span class="material-symbols-outlined text-lg">chevron_right</span>
</a>
</li>
</ul>
</nav>

</div>
</div>
</main>
</div>
</div>
</body>
</html>