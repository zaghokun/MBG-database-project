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

// --- LOGIKA BACKEND (KPI & CHART) ---

// 1. Ambil KPI (Card Atas)
// Menggunakan null coalescing operator (?? 0) untuk mencegah error jika data kosong
$total_penerima = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT COUNT(*) FROM PENERIMA"))[0] ?? 0;
$total_mitra    = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT COUNT(*) FROM MITRA"))[0] ?? 0;
$total_paket    = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT SUM(kuantitas) FROM PAKETBANTUAN"))[0] ?? 0;

// Cek status yang dianggap "Selesai" (Sesuaikan dengan data di database Anda, misal: 'Diterima' atau 'Selesai')
$distribusi_selesai = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT COUNT(*) FROM DISTRIBUSI WHERE status_pengiriman IN ('Selesai', 'Diterima', 'Terkirim')"))[0] ?? 0;
$distribusi_proses  = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT COUNT(*) FROM DISTRIBUSI WHERE status_pengiriman NOT IN ('Selesai', 'Diterima', 'Terkirim')"))[0] ?? 0;

// 2. Data Chart Distribusi per Bulan (Line Chart)
$data_chart = mysqli_query($koneksi_db, "
    SELECT DATE_FORMAT(tanggal_kirim, '%Y-%m') AS bulan, COUNT(*) AS total
    FROM DISTRIBUSI
    GROUP BY bulan
    ORDER BY bulan ASC
    LIMIT 12
"); // Limit 12 bulan terakhir agar grafik tidak terlalu padat

$bulan = [];
$jumlah_distribusi = [];
while ($row = mysqli_fetch_assoc($data_chart)) {
    // Ubah format 2023-10 menjadi Oktober 2023 (Opsional, pakai format string sederhana dulu)
    $bulan[] = date('M Y', strtotime($row['bulan'])); 
    $jumlah_distribusi[] = $row['total'];
}

// 3. Data Chart Kategori Penerima (Pie/Doughnut Chart)
$data_kategori = mysqli_query($koneksi_db, "
    SELECT kategori_penerima, COUNT(*) AS total
    FROM PENERIMA
    GROUP BY kategori_penerima
");

$label_kategori = [];
$total_kategori = [];
while ($row = mysqli_fetch_assoc($data_kategori)) {
    $label_kategori[] = $row['kategori_penerima'];
    $total_kategori[] = $row['total'];
}
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Dashboard Laporan</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
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

<main class="flex-1 p-6 lg:p-10 overflow-hidden">
<div class="max-w-7xl mx-auto">
    
    <div class="flex flex-col gap-1 mb-8">
        <h1 class="text-[#111418] dark:text-white text-3xl font-black">Dashboard Laporan</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Ringkasan statistik program bantuan sosial.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Penerima</p>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($total_penerima) ?></p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                    <span class="material-symbols-outlined">handshake</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Mitra</p>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($total_mitra) ?></p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                    <span class="material-symbols-outlined">inventory_2</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Stok Paket</p>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($total_paket) ?></p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-green-100 text-green-600 rounded-lg">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Distribusi Selesai</p>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($distribusi_selesai) ?></p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                    <span class="material-symbols-outlined">pending</span>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Dalam Proses</p>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white"><?= number_format($distribusi_proses) ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tren Distribusi Bulanan</h3>
            <div class="relative h-72 w-full">
                <canvas id="chartDistribusi"></canvas>
            </div>
        </div>
        
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Kategori Penerima</h3>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="chartKategori"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Aktivitas Distribusi Terbaru</h3>
            <a href="distribusi/index.php" class="text-sm text-primary font-medium hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 font-medium">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Mitra Penyalur</th>
                        <th class="px-6 py-4">Penerima Manfaat</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php
                    $latest = mysqli_query($koneksi_db, "
                        SELECT d.distribusi_id, m.nama_mitra, r.nama_lengkap, d.tanggal_kirim, d.status_pengiriman
                        FROM DISTRIBUSI d
                        LEFT JOIN MITRA m ON d.mitra_id = m.mitra_id
                        LEFT JOIN PENERIMA r ON d.penerima_id = r.penerima_id
                        ORDER BY d.tanggal_kirim DESC
                        LIMIT 5
                    ");
                    
                    if(mysqli_num_rows($latest) > 0){
                        while ($row = mysqli_fetch_assoc($latest)) {
                            // Badge color logic
                            $status = strtolower($row['status_pengiriman']);
                            $badge_class = "bg-gray-100 text-gray-800";
                            if(strpos($status, 'selesai')!==false || strpos($status, 'terkirim')!==false) $badge_class = "bg-green-100 text-green-800";
                            elseif(strpos($status, 'proses')!==false) $badge_class = "bg-yellow-100 text-yellow-800";
                            elseif(strpos($status, 'gagal')!==false) $badge_class = "bg-red-100 text-red-800";
                    ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#<?= $row['distribusi_id'] ?></td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300"><?= htmlspecialchars($row['nama_mitra']) ?></td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400"><?= date('d M Y', strtotime($row['tanggal_kirim'])) ?></td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badge_class ?>">
                                <?= htmlspecialchars($row['status_pengiriman']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='5' class='px-6 py-8 text-center text-gray-500'>Belum ada data distribusi terbaru.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</main>
</div>
</div>

<script>
    // Konfigurasi Umum agar warna cocok dengan tema
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b'; // Slate-500
    
    // 1. Line Chart: Distribusi per Bulan
    const ctxLine = document.getElementById('chartDistribusi').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: <?= json_encode($bulan) ?>, // Data PHP
            datasets: [{
                label: 'Jumlah Distribusi',
                data: <?= json_encode($jumlah_distribusi) ?>, // Data PHP
                borderColor: '#137fec', // Primary Blue
                backgroundColor: 'rgba(19, 127, 236, 0.1)',
                borderWidth: 2,
                tension: 0.4, // Kurva halus
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#137fec',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [2, 4], color: '#e2e8f0' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Doughnut Chart: Kategori Penerima
    const ctxPie = document.getElementById('chartKategori').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($label_kategori) ?>, // Data PHP
            datasets: [{
                data: <?= json_encode($total_kategori) ?>, // Data PHP
                backgroundColor: [
                    '#137fec', // Blue
                    '#8b5cf6', // Purple
                    '#f59e0b', // Amber
                    '#10b981', // Green
                    '#ef4444', // Red
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, boxWidth: 8 }
                }
            },
            cutout: '70%', // Membuat donut lebih tipis
        }
    });
</script>

</body>
</html>