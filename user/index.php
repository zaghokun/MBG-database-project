<?php 
// 1. Integrasi Koneksi Database
include "../config/koneksi.php"; 

// Fix variabel koneksi (jaga-jaga jika menggunakan $koneksi atau $conn)
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
<title>Kelola Pengguna</title>
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
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-[#111418] dark:text-white/90">
<div class="relative flex min-h-screen w-full">
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

<main class="flex-1 flex-col p-6 lg:p-8">
<div class="flex flex-col w-full max-w-7xl mx-auto">
<div class="flex flex-wrap gap-2 mb-4">
<a class="text-[#617589] dark:text-slate-400 text-sm font-medium leading-normal hover:text-primary" href="../index.php">Dashboard</a>
<span class="text-[#617589] dark:text-slate-500 text-sm font-medium leading-normal">/</span>
<span class="text-[#111418] dark:text-white/90 text-sm font-medium leading-normal">Kelola Pengguna</span>
</div>

<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
<div class="flex flex-col gap-1">
<h1 class="text-[#111418] dark:text-white text-3xl font-bold leading-tight tracking-tight">Kelola Pengguna</h1>
<p class="text-[#617589] dark:text-slate-400 text-base font-normal leading-normal">Atur dan kelola akses pengguna untuk sistem.</p>
</div>
<a href="create.php" class="flex items-center justify-center gap-2 rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined">add</span>
<span class="truncate">Tambah Pengguna</span>
</a>
</div>

<div class="bg-white dark:bg-background-dark rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm p-4">
<div class="px-2 py-3">
<label class="flex flex-col h-12 w-full max-w-md">
<div class="flex w-full flex-1 items-stretch rounded-lg h-full">
<div class="text-[#617589] dark:text-slate-400 flex bg-background-light dark:bg-slate-800 items-center justify-center pl-4 rounded-l-lg">
<span class="material-symbols-outlined">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-lg text-[#111418] dark:text-white/90 focus:outline-0 focus:ring-2 focus:ring-primary/50 border-none bg-background-light dark:bg-slate-800 h-full placeholder:text-[#617589] dark:placeholder:text-slate-500 px-4 text-sm font-normal leading-normal" placeholder="Cari berdasarkan nama atau email" value=""/>
</div>
</label>
</div>

<div class="px-2 py-3 @container">
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead>
<tr class="border-b border-b-slate-200 dark:border-b-slate-800">
<th class="px-4 py-3 text-left text-[#617589] dark:text-slate-400 text-xs font-medium uppercase tracking-wider">Nama</th>
<th class="px-4 py-3 text-left text-[#617589] dark:text-slate-400 text-xs font-medium uppercase tracking-wider">Email</th>
<th class="px-4 py-3 text-left text-[#617589] dark:text-slate-400 text-xs font-medium uppercase tracking-wider">Peran</th>
<th class="px-4 py-3 text-left text-[#617589] dark:text-slate-400 text-xs font-medium uppercase tracking-wider">No HP</th>
<th class="px-4 py-3 text-left text-[#617589] dark:text-slate-400 text-xs font-medium uppercase tracking-wider">Status Akun</th>
<th class="px-4 py-3 text-left text-[#617589] dark:text-slate-400 text-xs font-medium uppercase tracking-wider">Aksi</th>
</tr>
</thead>
<tbody>

<?php
// QUERY PHP MENGGANTIKAN DATA STATIS
$query = mysqli_query($koneksi_db, "SELECT * FROM USER ORDER BY user_id DESC");

if (mysqli_num_rows($query) > 0) {
    while($row = mysqli_fetch_assoc($query)){
        // Logika untuk warna badge status
        $status_lower = strtolower($row['status_akun']);
        if ($status_lower == 'aktif') {
            $badge_class = 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300';
        } else {
            $badge_class = 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300';
        }
?>
    <tr class="border-b border-b-slate-200 dark:border-b-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
        <td class="h-[72px] px-4 py-2 text-[#111418] dark:text-white/90 text-sm font-medium leading-normal">
            <?= htmlspecialchars($row['nama']) ?>
        </td>
        <td class="h-[72px] px-4 py-2 text-[#617589] dark:text-slate-400 text-sm font-normal leading-normal">
            <?= htmlspecialchars($row['email']) ?>
        </td>
        <td class="h-[72px] px-4 py-2 text-[#617589] dark:text-slate-400 text-sm font-normal leading-normal">
            <?= htmlspecialchars($row['role']) ?>
        </td>
        <td class="h-[72px] px-4 py-2 text-[#617589] dark:text-slate-400 text-sm font-normal leading-normal">
            <?= htmlspecialchars($row['no_hp']) ?>
        </td>
        <td class="h-[72px] px-4 py-2 text-sm font-normal leading-normal">
            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold <?= $badge_class ?>">
                <?= htmlspecialchars($row['status_akun']) ?>
            </span>
        </td>
        <td class="h-[72px] px-4 py-2 text-sm font-bold leading-normal tracking-[0.015em]">
            <div class="flex items-center gap-2">
                <a href="update.php?id=<?= $row['user_id'] ?>" class="flex h-8 w-8 items-center justify-center rounded-lg text-[#617589] dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-primary dark:hover:text-primary transition-colors" title="Edit">
                    <span class="material-symbols-outlined text-base">edit</span>
                </a>
                <a href="delete.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus user <?= htmlspecialchars($row['nama']) ?>?')" class="flex h-8 w-8 items-center justify-center rounded-lg text-[#617589] dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-red-500 transition-colors" title="Hapus">
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
        <td colspan="6" class="text-center py-8 text-slate-500">
            Data pengguna belum tersedia.
        </td>
    </tr>
<?php } ?>

</tbody>
</table>
</div>
</div>
</div>

<div class="flex items-center justify-between mt-6 px-2">
<p class="text-sm text-[#617589] dark:text-slate-400">Menampilkan hasil dari database</p>
<div class="flex items-center gap-2">
<button class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 text-sm font-medium text-[#617589] dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-50 disabled:cursor-not-allowed" disabled="">Sebelumnya</button>
<button class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-3 text-sm font-medium text-[#617589] dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Berikutnya</button>
</div>
</div>
</div>
</main>
</div>
</body>
</html>