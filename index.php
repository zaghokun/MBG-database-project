<?php 
include "config/koneksi.php"; 

// --- [FIX: KOMPATIBILITAS VARIABEL KONEKSI] ---
// Jika config/koneksi.php menggunakan $conn (bukan $koneksi), kita samakan variabelnya.
if (isset($conn) && !isset($koneksi)) {
    $koneksi = $conn;
}

// Cek apakah koneksi berhasil sebelum lanjut
if (!isset($koneksi)) {
    die("<h3>Koneksi Gagal!</h3><p>Pastikan file <code>config/koneksi.php</code> ada dan mendefinisikan variabel <code>\$koneksi</code> atau <code>\$conn</code>.</p>");
}

// --- [BAGIAN LOGIKA DATABASE (REAL DATA)] ---

// 1. MENGHITUNG TOTAL PENERIMA
// Mengambil total baris dari tabel PENERIMA
$query_penerima = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM PENERIMA");
$stats_penerima = ($query_penerima) ? mysqli_fetch_assoc($query_penerima)['total'] : 0;

// 2. MENGHITUNG PERSENTASE DISTRIBUSI SELESAI
// A. Hitung Total Semua Data Distribusi
$query_total_dist = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM DISTRIBUSI");
$total_distribusi = ($query_total_dist) ? mysqli_fetch_assoc($query_total_dist)['total'] : 0;

// B. Hitung Data Distribusi yang Statusnya 'Selesai', 'Terkirim', atau 'Diterima'
$query_selesai = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM DISTRIBUSI WHERE status_pengiriman IN ('Selesai', 'Terkirim', 'Diterima')");
$jumlah_selesai = ($query_selesai) ? mysqli_fetch_assoc($query_selesai)['total'] : 0;

// C. Rumus Persentase (Mencegah error division by zero jika data masih kosong)
if($total_distribusi > 0) {
    $stats_distribusi = round(($jumlah_selesai / $total_distribusi) * 100);
} else {
    $stats_distribusi = 0;
}

// 3. MENGHITUNG DATA YANG PERLU TINDAKAN (PENDING)
// Mengambil data distribusi yang statusnya masih 'Pending', 'Diproses', 'Gagal', atau 'Retur'
$query_pending = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM DISTRIBUSI WHERE status_pengiriman IN ('Pending', 'Diproses', 'Gagal', 'Retur')");
$stats_pending = ($query_pending) ? mysqli_fetch_assoc($query_pending)['total'] : 0;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Database Bantuan</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            --card-hover-transform: translateY(-8px);
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        
        /* --- HEADER SECTION --- */
        .hero-section {
            background: var(--primary-gradient); /* Tema Dark Blue Professional */
            color: white;
            padding: 40px 0 120px; /* Padding bawah besar untuk overlap */
            position: relative;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 1;
        }

        /* Dekorasi Header */
        .bg-decoration {
            position: absolute;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            z-index: 0;
        }
        .circle-1 { width: 300px; height: 300px; top: -100px; left: -50px; }
        .circle-2 { width: 200px; height: 200px; bottom: 20px; right: 10%; }

        /* Top Bar (Date Only - Profile Removed) */
        .top-bar {
            display: flex;
            justify-content: space-between; /* Tetap space-between agar tanggal di kiri */
            align-items: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        /* --- STATS CARDS (QUICK VIEW) --- */
        .stats-container {
            margin-top: -80px; /* Overlap ke header */
            position: relative;
            z-index: 5;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-left: 5px solid #0d6efd;
            height: 100%;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: #e7f1ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d6efd;
            font-size: 1.5rem;
        }

        /* --- MAIN MENU GRID --- */
        .menu-card {
            background: white;
            border: none;
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            text-decoration: none;
            color: #444;
            display: block;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .menu-card:hover {
            transform: var(--card-hover-transform);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            color: #0d6efd;
        }
        
        /* Ikon Menu dengan Background Halus */
        .menu-icon-wrapper {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        /* Warna-warni spesifik untuk setiap menu */
        .menu-dashboard .menu-icon-wrapper { background: #e0f2fe; color: #0284c7; }
        .menu-distribusi .menu-icon-wrapper { background: #dcfce7; color: #16a34a; }
        .menu-penerima .menu-icon-wrapper { background: #fef9c3; color: #ca8a04; }
        .menu-paket .menu-icon-wrapper { background: #fee2e2; color: #dc2626; }
        .menu-mitra .menu-icon-wrapper { background: #f3e8ff; color: #9333ea; }
        .menu-laporan .menu-icon-wrapper { background: #ffedd5; color: #ea580c; }
        .menu-user .menu-icon-wrapper { background: #f1f5f9; color: #475569; }

        .menu-card:hover .menu-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .card-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* Animasi Masuk */
        .animate-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="hero-section">
        <div class="bg-decoration circle-1"></div>
        <div class="bg-decoration circle-2"></div>
        
        <div class="container">
            <!-- Top Bar: Hanya Waktu, Profil Dihapus -->
            <div class="top-bar animate-up">
                <div class="text-white-50 small" id="current-date">
                    <i class="bi bi-calendar-event me-2"></i> ...
                </div>
                
                <!-- BAGIAN PROFIL SUDAH DIHAPUS DISINI SESUAI REQUEST -->
                <div></div> 
            </div>

            <!-- Judul Utama -->
            <div class="text-center position-relative z-2 animate-up delay-1">
                <h2 class="fw-bold mb-1">Portal Manajemen Bantuan MBG</h2>
                <p class="text-white-50 mb-0">Sistem Terpadu Penyaluran Bantuan Sosial</p>
            </div>
        </div>
    </div>

    <!-- Container Utama -->
    <div class="container pb-5">
        
        <!-- Baris Statistik Cepat (DATA DARI DATABASE) -->
        <div class="row g-4 stats-container justify-content-center animate-up delay-1">
            <div class="col-md-4">
                <div class="stat-card">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Total Penerima</div>
                        <h3 class="fw-bold mb-0 text-dark"><?php echo number_format($stats_penerima); ?></h3>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="border-left-color: #198754;">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Distribusi Selesai</div>
                        <h3 class="fw-bold mb-0 text-success"><?php echo $stats_distribusi; ?>%</h3>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="border-left-color: #fd7e14;">
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Perlu Tindakan</div>
                        <h3 class="fw-bold mb-0 text-warning"><?php echo $stats_pending; ?> Data</h3>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Grid -->
        <h6 class="text-muted fw-bold text-uppercase mb-3 ps-2 animate-up delay-2" style="font-size: 0.8rem; letter-spacing: 1px;">Menu Utama</h6>
        
        <div class="row g-4 justify-content-center animate-up delay-2">
            
            <!-- Dashboard -->
            <div class="col-6 col-md-4 col-lg-3">
                <a href="dashboard/index.php" class="menu-card menu-dashboard">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div class="card-title h6 fw-bold">Dashboard</div>
                    <div class="small text-muted">Ringkasan Utama</div>
                </a>
            </div>

            <!-- Distribusi -->
            <div class="col-6 col-md-4 col-lg-3">
                <a href="distribusi/index.php" class="menu-card menu-distribusi">
                    <?php if($stats_pending > 0): ?>
                        <span class="badge bg-danger card-badge rounded-pill"><?php echo $stats_pending; ?> Pending</span>
                    <?php endif; ?>
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="card-title h6 fw-bold">Distribusi</div>
                    <div class="small text-muted">Jadwal & Kirim</div>
                </a>
            </div>

            <!-- Data Penerima -->
            <div class="col-6 col-md-4 col-lg-3">
                <a href="penerima/index.php" class="menu-card menu-penerima">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="card-title h6 fw-bold">Penerima</div>
                    <div class="small text-muted">Data Kependudukan</div>
                </a>
            </div>

            <!-- Paket Bantuan -->
            <div class="col-6 col-md-4 col-lg-3">
                <a href="paketbantuan/index.php" class="menu-card menu-paket">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div class="card-title h6 fw-bold">Stok Paket</div>
                    <div class="small text-muted">Logistik & Item</div>
                </a>
            </div>

            <!-- Mitra -->
            <div class="col-6 col-md-4 col-lg-3">
                <a href="mitra/index.php" class="menu-card menu-mitra">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <div class="card-title h6 fw-bold">Mitra</div>
                    <div class="small text-muted">Partner Penyalur</div>
                </a>
            </div>

            <!-- Laporan -->
            <div class="col-6 col-md-4 col-lg-3">
                <a href="laporandata/index.php" class="menu-card menu-laporan">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div class="card-title h6 fw-bold">Laporan</div>
                    <div class="small text-muted">Cetak Dokumen</div>
                </a>
            </div>

            <!-- User Management -->
            <div class="col-6 col-md-4 col-lg-3">
                <a href="user/index.php" class="menu-card menu-user">
                    <div class="menu-icon-wrapper">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div class="card-title h6 fw-bold">Admin</div>
                    <div class="small text-muted">Kelola Akses</div>
                </a>
            </div>

        </div>

        <!-- Footer Simple -->
        <div class="text-center mt-5 mb-3 text-muted small animate-up delay-3">
            &copy; <?php echo date('Y'); ?> Sistem Informasi Bantuan MBG V.2.0
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script Waktu Sederhana -->
    <script>
        const dateElement = document.getElementById('current-date');
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateElement.innerHTML = '<i class="bi bi-calendar-event me-2"></i>' + new Date().toLocaleDateString('id-ID', options);
    </script>
</body>
</html>