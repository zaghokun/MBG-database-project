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

// 2. Ambil ID & Data Lama
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$distribusi_id = $_GET['id'];
$query_data = mysqli_query($koneksi_db, "SELECT * FROM DISTRIBUSI WHERE distribusi_id = '$distribusi_id'");
$row = mysqli_fetch_assoc($query_data);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// 3. Proses Update Data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $paket_id       = $_POST['paket_id'];
    $penerima_id    = $_POST['penerima_id'];
    $mitra_id       = $_POST['mitra_id'];
    $tanggal_kirim  = $_POST['tanggal_kirim'];
    $tanggal_terima = $_POST['tanggal_terima'];
    $lokasi         = $_POST['lokasi_pengiriman'];
    $status         = $_POST['status_pengiriman'];
    $catatan        = $_POST['catatan_petugas'];

    // Handle File Upload
    $bukti_nama = $_FILES['bukti_pengiriman']['name'];

    if ($bukti_nama != "") {
        $tmp    = $_FILES['bukti_pengiriman']['tmp_name'];
        $folder = "../uploads/";

        // Buat folder jika belum ada
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $nama_baru = time() . "_" . $bukti_nama;
        
        if (move_uploaded_file($tmp, $folder . $nama_baru)) {
            // Hapus file lama jika ada dan file baru berhasil diupload
            if ($row['bukti_pengiriman'] != "" && file_exists($folder . $row['bukti_pengiriman'])) {
                unlink($folder . $row['bukti_pengiriman']);
            }
            $bukti_final = $nama_baru;
        } else {
            // Fallback jika gagal upload
            $bukti_final = $row['bukti_pengiriman'];
        }
    } else {
        $bukti_final = $row['bukti_pengiriman']; // Tetap pakai yang lama
    }

    $query_update = "UPDATE DISTRIBUSI SET 
                paket_id = '$paket_id',
                penerima_id = '$penerima_id',
                mitra_id = '$mitra_id',
                tanggal_kirim = '$tanggal_kirim',
                tanggal_terima = '$tanggal_terima',
                lokasi_pengiriman = '$lokasi',
                status_pengiriman = '$status',
                bukti_pengiriman = '$bukti_final',
                catatan_petugas = '$catatan'
              WHERE distribusi_id = '$distribusi_id'";

    if (mysqli_query($koneksi_db, $query_update)) {
        echo "<script>alert('Data distribusi berhasil diperbarui'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update data: " . mysqli_error($koneksi_db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Distribusi</title>
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
          borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
        },
      },
    }
</script>
<style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
<div class="relative flex min-h-screen w-full flex-col">
<div class="flex h-full w-full">

<aside class="w-64 flex-shrink-0 bg-white dark:bg-background-dark dark:border-r dark:border-gray-700 hidden lg:flex flex-col">
    <div class="flex h-full flex-col justify-between p-4">
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-3 p-2">
                <div class="bg-primary rounded-lg flex items-center justify-center size-10">
                    <span class="material-symbols-outlined text-white text-2xl">all_inbox</span>
                </div>
                <h1 class="text-xl font-bold text-[#111418] dark:text-white">AidFlow</h1>
            </div>
            <div class="flex flex-col gap-2 pt-4">
                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../index.php">
                    <span class="material-symbols-outlined">dashboard</span>
                    <p class="text-sm font-medium">Dashboard</p>
                </a>
                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../mitra/index.php">
                    <span class="material-symbols-outlined">handshake</span>
                    <p class="text-sm font-medium">Mitra</p>
                </a>
                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../user/index.php">
                    <span class="material-symbols-outlined">person</span>
                    <p class="text-sm font-medium">Pengguna</p>
                </a>
                <a class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../penerima/index.php">
                    <span class="material-symbols-outlined">group</span>
                    <p class="text-sm font-medium">Penerima</p>
                </a>
                <a class="flex items-center gap-3 rounded-lg bg-primary/10 px-3 py-2 text-primary dark:bg-primary/20 dark:text-white" href="index.php">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                    <p class="text-sm font-medium">Distribusi</p>
                </a>
            </div>
        </div>
    </div>
</aside>

<main class="flex-1 p-6 lg:p-10">
<div class="mx-auto max-w-4xl">
    <div class="flex flex-wrap gap-2 pb-4">
        <a class="text-sm font-medium text-[#617589] dark:text-gray-400 hover:text-primary" href="index.php">Distribusi</a>
        <span class="text-sm font-medium text-[#617589] dark:text-gray-400">/</span>
        <span class="text-sm font-medium text-[#111418] dark:text-white">Edit Distribusi</span>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
        <p class="text-3xl font-bold text-[#111418] dark:text-white">Edit Distribusi</p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-background-dark/50">
        
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                
                <label class="flex flex-col md:col-span-2">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Paket Bantuan</p>
                    <select name="paket_id" class="form-select w-full rounded-lg border-[#dbe0e6] bg-white text-base text-[#111418] focus:border-primary focus:ring-primary/50 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <?php
                        $paket = mysqli_query($koneksi_db, "SELECT * FROM PAKETBANTUAN");
                        while ($p = mysqli_fetch_assoc($paket)) {
                            $selected = ($p['paket_id'] == $row['paket_id']) ? "selected" : "";
                            echo "<option value='{$p['paket_id']}' $selected>{$p['nama_paket']}</option>";
                        }
                        ?>
                    </select>
                </label>

                <label class="flex flex-col">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Penerima</p>
                    <select name="penerima_id" class="form-select w-full rounded-lg border-[#dbe0e6] bg-white text-base text-[#111418] focus:border-primary focus:ring-primary/50 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <?php
                        $penerima = mysqli_query($koneksi_db, "SELECT * FROM PENERIMA");
                        while ($pr = mysqli_fetch_assoc($penerima)) {
                            $selected = ($pr['penerima_id'] == $row['penerima_id']) ? "selected" : "";
                            echo "<option value='{$pr['penerima_id']}' $selected>{$pr['nama_lengkap']}</option>";
                        }
                        ?>
                    </select>
                </label>

                <label class="flex flex-col">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Mitra</p>
                    <select name="mitra_id" class="form-select w-full rounded-lg border-[#dbe0e6] bg-white text-base text-[#111418] focus:border-primary focus:ring-primary/50 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <?php
                        $mitra = mysqli_query($koneksi_db, "SELECT * FROM MITRA");
                        while ($m = mysqli_fetch_assoc($mitra)) {
                            $selected = ($m['mitra_id'] == $row['mitra_id']) ? "selected" : "";
                            echo "<option value='{$m['mitra_id']}' $selected>{$m['nama_mitra']}</option>";
                        }
                        ?>
                    </select>
                </label>

                <label class="flex flex-col md:col-span-2">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Status Pengiriman</p>
                    <select name="status_pengiriman" class="form-select w-full rounded-lg border-[#dbe0e6] bg-white text-base text-[#111418] focus:border-primary focus:ring-primary/50 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                        <?php
                        $status_opsi = ["Dikemas", "Dikirim", "Diterima", "Selesai", "Gagal"];
                        foreach ($status_opsi as $s) {
                            $selected = ($row['status_pengiriman'] == $s) ? "selected" : "";
                            echo "<option value='$s' $selected>$s</option>";
                        }
                        ?>
                    </select>
                </label>

                <label class="flex flex-col">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Tanggal Kirim</p>
                    <input type="date" name="tanggal_kirim" value="<?= $row['tanggal_kirim'] ?>" class="form-input w-full rounded-lg border-[#dbe0e6] bg-white text-base text-[#111418] focus:border-primary focus:ring-primary/50 dark:border-gray-600 dark:bg-gray-800 dark:text-white" />
                </label>

                <label class="flex flex-col">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Tanggal Terima</p>
                    <input type="date" name="tanggal_terima" value="<?= $row['tanggal_terima'] ?>" class="form-input w-full rounded-lg border-[#dbe0e6] bg-white text-base text-[#111418] focus:border-primary focus:ring-primary/50 dark:border-gray-600 dark:bg-gray-800 dark:text-white" />
                </label>

                <label class="flex flex-col md:col-span-2">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Lokasi Pengiriman</p>
                    <input type="text" name="lokasi_pengiriman" value="<?= htmlspecialchars($row['lokasi_pengiriman']) ?>" class="form-input w-full rounded-lg border-[#dbe0e6] bg-white text-base text-[#111418] focus:border-primary focus:ring-primary/50 dark:border-gray-600 dark:bg-gray-800 dark:text-white" />
                </label>

                <div class="md:col-span-2">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Bukti Pengiriman</p>
                    
                    <?php if (!empty($row['bukti_pengiriman'])): ?>
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 mb-1">File saat ini:</p>
                            
                            <img src="../uploads/<?= $row['bukti_pengiriman'] ?>" alt="Bukti Lama" class="h-32 rounded-lg border border-gray-300 object-cover">
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-col items-center gap-4 rounded-lg border-2 border-dashed border-gray-300 p-6 dark:border-gray-600">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-4xl text-gray-400">cloud_upload</span>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Klik tombol di bawah untuk mengganti foto (Opsional)</p>
                            <input class="mt-4 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" id="file-upload" name="bukti_pengiriman" type="file" accept="image/*"/>
                        </div>
                    </div>
                </div>

                <label class="flex flex-col md:col-span-2">
                    <p class="pb-2 text-sm font-medium text-[#111418] dark:text-gray-200">Catatan Petugas</p>
                    <textarea name="catatan_petugas" class="form-textarea w-full rounded-lg border-[#dbe0e6] bg-white text-base text-[#111418] focus:border-primary focus:ring-primary/50 dark:border-gray-600 dark:bg-gray-800 dark:text-white" rows="4"><?= htmlspecialchars($row['catatan_petugas']) ?></textarea>
                </label>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="index.php" class="rounded-lg bg-gray-100 px-5 py-2.5 text-sm font-medium text-[#111418] hover:bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                    Kembali
                </a>
                <button type="submit" class="rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary/90">
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