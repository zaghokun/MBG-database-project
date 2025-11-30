<?php 
// 1. Integrasi Koneksi Database
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
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Kelola Data Distribusi</title>
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
                        "display": ["Inter"]
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
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="flex flex-row h-full">

<div class="flex-shrink-0 w-64 bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-700 hidden lg:block">
<div class="flex h-full min-h-screen flex-col justify-between p-4">
<div class="flex flex-col gap-4">
<div class="flex items-center gap-3 p-2">
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="User avatar image" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCtcCAzFNH59NHbCGuJesGvOfBrFRsKBhV7E9NNabBOU9_jfNc-tYnDAMl-ZZ2xdjL5fiqZHuYNrWQkWvZ21mEouybjQlpLato5HiCk0vMSSB0KPPAfeJHLiTUKm9m7-iZ42hdWXePKQsnzG9zueRfBTK0rbGUmO99aLltvWpWaf37kyKTx9fjIzhrhn2F2tP1y6c8siDmUxoxSo2zw6juavq5ZYhhpdQ0oL5rL0TIT7Cpe95-I0DEArTYr-yRNrlPiZQ1QDKFGy0iJ");'></div>
<div class="flex flex-col">
<h1 class="text-[#111418] dark:text-white text-base font-medium leading-normal">Admin Distribusi</h1>
<p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">Administrator</p>
</div>
</div>
<div class="flex flex-col gap-2 mt-4">
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-[#617589] dark:text-gray-400 hover:bg-primary/10 hover:text-primary dark:hover:text-primary" href="../index.php">
<span class="material-symbols-outlined">dashboard</span>
<p class="text-sm font-medium leading-normal">Dashboard</p>
</a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1">local_shipping</span>
<p class="text-sm font-medium leading-normal">Distribusi</p>
</a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-[#617589] dark:text-gray-400 hover:bg-primary/10 hover:text-primary dark:hover:text-primary" href="../mitra/index.php">
<span class="material-symbols-outlined">groups</span>
<p class="text-sm font-medium leading-normal">Mitra</p>
</a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-[#617589] dark:text-gray-400 hover:bg-primary/10 hover:text-primary dark:hover:text-primary" href="../user/index.php">
<span class="material-symbols-outlined">account_circle</span>
<p class="text-sm font-medium leading-normal">Pengguna</p>
</a>
</div>
</div>
<div class="flex flex-col gap-1">
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-[#617589] dark:text-gray-400 hover:bg-primary/10 hover:text-primary dark:hover:text-primary" href="#">
<span class="material-symbols-outlined">logout</span>
<p class="text-sm font-medium leading-normal">Logout</p>
</a>
</div>
</div>
</div>

<main class="flex-1 p-8">
<div class="flex flex-col max-w-7xl mx-auto">
<div class="flex flex-wrap justify-between items-center gap-4">
<div class="flex flex-col gap-1">
<p class="text-[#111418] dark:text-white text-3xl font-bold tracking-tight">Data Distribusi</p>
<p class="text-[#617589] dark:text-gray-400 text-base font-normal leading-normal">Kelola data paket, penerima, dan mitra distribusi.</p>
</div>
<a href="create.php" class="flex items-center justify-center gap-2 overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined">add</span>
<span class="truncate">Tambah Distribusi</span>
</a>
</div>

<div class="mt-8 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
<div class="flex flex-wrap items-center justify-between gap-4">
<div class="flex items-center gap-2 w-full md:w-auto">
<div class="relative w-full max-w-xs">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<span class="material-symbols-outlined text-gray-400">search</span>
</div>
<input class="block w-full h-10 pl-10 pr-3 rounded-lg bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 focus:ring-primary focus:border-primary" placeholder="Cari berdasarkan paket, penerima..." type="text"/>
</div>
<button class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-lg bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 px-4">
<p class="text-[#111418] dark:text-white text-sm font-medium leading-normal">Status</p>
<span class="material-symbols-outlined text-[#617589] dark:text-gray-400">expand_more</span>
</button>
</div>
</div>
</div>

<div class="mt-6 @container">
<div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
<div class="overflow-x-auto">
<table class="w-full min-w-max">
<thead class="bg-gray-50 dark:bg-gray-900/50">
<tr>
<th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">ID</th>
<th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">Paket</th>
<th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">Penerima</th>
<th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">Mitra</th>
<th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">Tgl Kirim</th>
<th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">Status</th>
<th class="px-4 py-3 text-left text-[#111418] dark:text-gray-300 text-xs font-medium uppercase tracking-wider">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200 dark:divide-gray-700">

<?php
// Query Data dengan JOIN (Sama seperti logika PHP Anda)
$query = "
    SELECT d.*, 
           p.nama_paket, 
           r.nama_lengkap AS nama_penerima, 
           m.nama_mitra
    FROM DISTRIBUSI d
    LEFT JOIN PAKETBANTUAN p ON d.paket_id = p.paket_id
    LEFT JOIN PENERIMA r ON d.penerima_id = r.penerima_id
    LEFT JOIN MITRA m ON d.mitra_id = m.mitra_id
    ORDER BY d.distribusi_id DESC
";

$result = mysqli_query($koneksi_db, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Logika Status Badge
        $status = $row['status_pengiriman'];
        $badge_class = "";
        
        // Normalisasi status ke lowercase untuk pengecekan
        $status_check = strtolower($status);
        
        if (strpos($status_check, 'terkirim') !== false || strpos($status_check, 'selesai') !== false || strpos($status_check, 'diterima') !== false) {
            $badge_class = "bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300";
        } elseif (strpos($status_check, 'proses') !== false || strpos($status_check, 'dikirim') !== false || strpos($status_check, 'pending') !== false) {
            $badge_class = "bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300";
        } elseif (strpos($status_check, 'gagal') !== false || strpos($status_check, 'batal') !== false) {
            $badge_class = "bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300";
        } else {
            $badge_class = "bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300";
        }
?>
    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
        <td class="px-4 py-3 text-[#617589] dark:text-gray-400 text-sm">
            #<?= $row['distribusi_id'] ?>
        </td>
        <td class="px-4 py-3 text-[#111418] dark:text-white text-sm font-medium">
            <?= htmlspecialchars($row['nama_paket']) ?>
        </td>
        <td class="px-4 py-3 text-[#617589] dark:text-gray-400 text-sm">
            <?= htmlspecialchars($row['nama_penerima']) ?>
        </td>
        <td class="px-4 py-3 text-[#617589] dark:text-gray-400 text-sm">
            <?= htmlspecialchars($row['nama_mitra']) ?>
        </td>
        <td class="px-4 py-3 text-[#617589] dark:text-gray-400 text-sm">
            <?= htmlspecialchars($row['tanggal_kirim']) ?>
        </td>
        <td class="px-4 py-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badge_class ?>">
                <?= htmlspecialchars($row['status_pengiriman']) ?>
            </span>
        </td>
        <td class="px-4 py-3 text-sm font-medium">
            <div class="flex items-center gap-2">
                <a href="update.php?id=<?= $row['distribusi_id'] ?>" class="text-primary hover:text-primary/80" title="Edit">
                    <span class="material-symbols-outlined text-base">edit</span>
                </a>
                <a href="delete.php?id=<?= $row['distribusi_id'] ?>" onclick="return confirm('Yakin hapus data distribusi ini?');" class="text-red-500 hover:text-red-400" title="Hapus">
                    <span class="material-symbols-outlined text-base">delete</span>
                </a>
            </div>
        </td>
    </tr>
<?php 
    } // End While
} else {
?>
    <tr>
        <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
            <span class="material-symbols-outlined text-3xl mb-2">local_shipping</span>
            <p>Belum ada data distribusi.</p>
        </td>
    </tr>
<?php } ?>

</tbody>
</table>
</div>
</div>
</div>

</div>
</main>
</div>
</div>
</body>
</html>