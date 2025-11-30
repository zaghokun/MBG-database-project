<?php 
include "config/koneksi.php"; 

// --- [FIX: KOMPATIBILITAS VARIABEL KONEKSI] ---
// Sesuaikan variabel koneksi yang digunakan oleh skrip PHP di bawah ini.
// Asumsi: Jika $conn ada, gunakan $conn. Jika $koneksi ada, gunakan $koneksi.
$koneksi_db = null;
if (isset($conn)) {
    $koneksi_db = $conn;
} elseif (isset($koneksi)) {
    $koneksi_db = $koneksi;
}

// Cek apakah koneksi berhasil sebelum lanjut
if (!$koneksi_db) {
    die("<h3>Koneksi Gagal!</h3><p>Pastikan file <code>config/koneksi.php</code> ada dan mendefinisikan variabel koneksi (<code>\$koneksi</code> atau <code>\$conn</code>).</p>");
}

// --- [BAGIAN LOGIKA DATABASE (REAL DATA)] ---

// 1. MENGHITUNG TOTAL PENERIMA
$query_penerima = mysqli_query($koneksi_db, "SELECT COUNT(*) as total FROM PENERIMA");
$stats_penerima = ($query_penerima) ? mysqli_fetch_assoc($query_penerima)['total'] : 0;

// 2. MENGHITUNG PERSENTASE DISTRIBUSI SELESAI
$query_total_dist = mysqli_query($koneksi_db, "SELECT COUNT(*) as total FROM DISTRIBUSI");
$total_distribusi = ($query_total_dist) ? mysqli_fetch_assoc($query_total_dist)['total'] : 0;

$query_selesai = mysqli_query($koneksi_db, "SELECT COUNT(*) as total FROM DISTRIBUSI WHERE status_pengiriman IN ('Selesai', 'Terkirim', 'Diterima')");
$jumlah_selesai = ($query_selesai) ? mysqli_fetch_assoc($query_selesai)['total'] : 0;

if($total_distribusi > 0) {
    // Menghitung jumlah yang selesai, BUKAN persentase, agar cocok dengan format di Tailwind
    // Format Tailwind sebelumnya adalah angka '3,890', bukan persentase.
    $stats_distribusi_count = $jumlah_selesai; 
    // Jika Anda benar-benar ingin menggunakan persentase (seperti di kode Bootstrap):
    // $stats_distribusi_percent = round(($jumlah_selesai / $total_distribusi) * 100);
} else {
    $stats_distribusi_count = 0;
    // $stats_distribusi_percent = 0;
}

// 3. MENGHITUNG DATA YANG PERLU TINDAKAN (PENDING)
$query_pending = mysqli_query($koneksi_db, "SELECT COUNT(*) as total FROM DISTRIBUSI WHERE status_pengiriman IN ('Pending', 'Diproses', 'Gagal', 'Retur')");
$stats_pending = ($query_pending) ? mysqli_fetch_assoc($query_pending)['total'] : 0;

?>
<!DOCTYPE html>
<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Dashboard Admin MBG</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
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
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-slate-200 dark:border-slate-800 px-10 py-3 bg-white dark:bg-background-dark">
<div class="flex items-center gap-4 text-slate-900 dark:text-white">
<div class="size-6 text-primary">
<svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M13.8261 17.4264C16.7203 18.1174 20.2244 18.5217 24 18.5217C27.7756 18.5217 31.2797 18.1174 34.1739 17.4264C36.9144 16.7722 39.9967 15.2331 41.3563 14.1648L24.8486 40.6391C24.4571 41.267 23.5429 41.267 23.1514 40.6391L6.64374 14.1648C8.00331 15.2331 11.0856 16.7722 13.8261 17.4264Z" fill="currentColor"></path>
<path clip-rule="evenodd" d="M39.998 12.236C39.9944 12.2537 39.9875 12.2845 39.9748 12.3294C39.9436 12.4399 39.8949 12.5741 39.8346 12.7175C39.8168 12.7597 39.7989 12.8007 39.7813 12.8398C38.5103 13.7113 35.9788 14.9393 33.7095 15.4811C30.9875 16.131 27.6413 16.5217 24 16.5217C20.3587 16.5217 17.0125 16.131 14.2905 15.4811C12.0012 14.9346 9.44505 13.6897 8.18538 12.8168C8.17384 12.7925 8.16216 12.767 8.15052 12.7408C8.09919 12.6249 8.05721 12.5114 8.02977 12.411C8.00356 12.3152 8.00039 12.2667 8.00004 12.2612C8.00004 12.261 8 12.2607 8.00004 12.2612C8.00004 12.2359 8.0104 11.9233 8.68485 11.3686C9.34546 10.8254 10.4222 10.2469 11.9291 9.72276C14.9242 8.68098 19.1919 8 24 8C28.8081 8 33.0758 8.68098 36.0709 9.72276C37.5778 10.2469 38.6545 10.8254 39.3151 11.3686C39.9006 11.8501 39.9857 12.1489 39.998 12.236ZM4.95178 15.2312L21.4543 41.6973C22.6288 43.5809 25.3712 43.5809 26.5457 41.6973L43.0534 15.223C43.0709 15.1948 43.0878 15.1662 43.104 15.1371L41.3563 14.1648C43.104 15.1371 43.1038 15.1374 43.104 15.1371L43.1051 15.135L43.1065 15.1325L43.1101 15.1261L43.1199 15.1082C43.1276 15.094 43.1377 15.0754 43.1497 15.0527C43.1738 15.0075 43.2062 14.9455 43.244 14.8701C43.319 14.7208 43.4196 14.511 43.5217 14.2683C43.6901 13.8679 44 13.0689 44 12.2609C44 10.5573 43.003 9.22254 41.8558 8.2791C40.6947 7.32427 39.1354 6.55361 37.385 5.94477C33.8654 4.72057 29.133 4 24 4C18.867 4 14.1346 4.72057 10.615 5.94478C8.86463 6.55361 7.30529 7.32428 6.14419 8.27911C4.99695 9.22255 3.99999 10.5573 3.99999 12.2609C3.99999 13.1275 4.29264 13.9078 4.49321 14.3607C4.60375 14.6102 4.71348 14.8196 4.79687 14.9689C4.83898 15.0444 4.87547 15.1065 4.9035 15.1529C4.91754 15.1762 4.92954 15.1957 4.93916 15.2111L4.94662 15.223L4.95178 15.2312ZM35.9868 18.996L24 38.22L12.0131 18.996C12.4661 19.1391 12.9179 19.2658 13.3617 19.3718C16.4281 20.1039 20.0901 20.5217 24 20.5217C27.9099 20.5217 31.5719 20.1039 34.6383 19.3718C35.082 19.2658 35.5339 19.1391 35.9868 18.996Z" fill="currentColor" fill-rule="evenodd"></path>
</svg>
</div>
<h2 class="text-slate-900 dark:text-white text-lg font-bold leading-tight tracking-[-0.015em]">Admin MBG</h2>
</div>
<div class="flex flex-1 justify-end gap-8">
<div class="flex items-center gap-4">
<button class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 w-10 bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-white gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0">
<span class="material-symbols-outlined text-lg">notifications</span>
</button>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="User avatar image" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAEkbgwMxyapSb-_kFy8Wg2K5ApKo_gZa4AQYgZkfMZ5WW42oM0_xfhG_MxOSPhjWj0ZxEgF8OkiEvK47OGExCTzamvIyG6XXq9t-COiRUAPGSmOy2V2RiQT9S38UFSQLz12eqBunpWcX_Ah4oolUs1efARkNuU7a5wbb6F3IX6qiPuJ812E__YY01jpBxyr4XEDjB5Z2k10q8pKord_c6H2eFMPfmkk7CHY65GMlPKC5HFAu-CximcE2FekKgDphdSl3YQ4cMCPnrg");'></div>
</div>
</div>
</header>

<main class="px-10 py-8">
<div class="mx-auto max-w-7xl">
<div class="mb-8">
<h1 class="text-slate-900 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em] mb-1">Dashboard MBG</h1>
<p class="text-slate-600 dark:text-slate-400">Selamat datang! Kelola semua aspek program MBG dari sini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-start gap-6">
        <div class="flex items-center justify-center size-12 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
            <span class="material-symbols-outlined !text-3xl">groups</span>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Penerima</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">
                <?= number_format($stats_penerima) ?>
            </p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-start gap-6">
        <div class="flex items-center justify-center size-12 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400">
            <span class="material-symbols-outlined !text-3xl">task_alt</span>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Distribusi Selesai</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">
                <?= number_format($stats_distribusi_count) ?>
            </p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex items-start gap-6">
        <div class="flex items-center justify-center size-12 rounded-full bg-amber-100 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400">
            <span class="material-symbols-outlined !text-3xl">pending_actions</span>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Tindakan Diperlukan</p>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">
                <?= number_format($stats_pending) ?>
            </p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <a class="group bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-primary dark:hover:border-primary hover:shadow-lg transition-all" href="index.php">
        <div class="flex items-center justify-center size-12 rounded-lg bg-slate-100 dark:bg-slate-800 mb-4 text-primary group-hover:bg-primary/10 transition-colors">
            <span class="material-symbols-outlined !text-3xl">dashboard</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Dasbor</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400">Ringkasan analitik dan metrik utama.</p>
    </a>
    
    <a class="group bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-primary dark:hover:border-primary hover:shadow-lg transition-all" href="distribusi/index.php">
        <div class="flex items-center justify-center size-12 rounded-lg bg-slate-100 dark:bg-slate-800 mb-4 text-primary group-hover:bg-primary/10 transition-colors">
            <span class="material-symbols-outlined !text-3xl">local_shipping</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">
            Distribusi
            <?php if($stats_pending > 0): ?>
             <span class="ml-2 inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Pending</span>
            <?php endif; ?>
        </h3>
        <p class="text-sm text-slate-600 dark:text-slate-400">Kelola dan lacak semua distribusi bantuan.</p>
    </a>
    
    <a class="group bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-primary dark:hover:border-primary hover:shadow-lg transition-all" href="penerima/index.php">
        <div class="flex items-center justify-center size-12 rounded-lg bg-slate-100 dark:bg-slate-800 mb-4 text-primary group-hover:bg-primary/10 transition-colors">
            <span class="material-symbols-outlined !text-3xl">group</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Penerima</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400">Akses dan kelola data penerima.</p>
    </a>
    
    <a class="group bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-primary dark:hover:border-primary hover:shadow-lg transition-all" href="paketbantuan/index.php">
        <div class="flex items-center justify-center size-12 rounded-lg bg-slate-100 dark:bg-slate-800 mb-4 text-primary group-hover:bg-primary/10 transition-colors">
            <span class="material-symbols-outlined !text-3xl">inventory_2</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Stok Paket</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400">Pantau ketersediaan paket bantuan.</p>
    </a>
    
    <a class="group bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-primary dark:hover:border-primary hover:shadow-lg transition-all" href="mitra/index.php">
        <div class="flex items-center justify-center size-12 rounded-lg bg-slate-100 dark:bg-slate-800 mb-4 text-primary group-hover:bg-primary/10 transition-colors">
            <span class="material-symbols-outlined !text-3xl">handshake</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Mitra</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400">Lihat dan kelola informasi mitra.</p>
    </a>
    
    <a class="group bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-primary dark:hover:border-primary hover:shadow-lg transition-all" href="laporandata/index.php">
        <div class="flex items-center justify-center size-12 rounded-lg bg-slate-100 dark:bg-slate-800 mb-4 text-primary group-hover:bg-primary/10 transition-colors">
            <span class="material-symbols-outlined !text-3xl">analytics</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Laporan</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400">Hasilkan dan unduh laporan sistem.</p>
    </a>
    
    <a class="group bg-white dark:bg-slate-900/50 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:border-primary dark:hover:border-primary hover:shadow-lg transition-all" href="user/index.php">
        <div class="flex items-center justify-center size-12 rounded-lg bg-slate-100 dark:bg-slate-800 mb-4 text-primary group-hover:bg-primary/10 transition-colors">
            <span class="material-symbols-outlined !text-3xl">admin_panel_settings</span>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Admin</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400">Kelola pengguna dan pengaturan sistem.</p>
    </a>
</div>

</div>
</main>
</div>
</div>
</body>
</html>