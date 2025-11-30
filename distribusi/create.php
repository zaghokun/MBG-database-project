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

// 2. Logika Simpan Data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $paket_id       = $_POST['paket_id'];
    $penerima_id    = $_POST['penerima_id'];
    $mitra_id       = $_POST['mitra_id'];
    $tanggal_kirim  = $_POST['tanggal_kirim'];
    $tanggal_terima = $_POST['tanggal_terima'];
    $lokasi         = $_POST['lokasi_pengiriman'];
    $status         = $_POST['status_pengiriman'];
    $catatan        = $_POST['catatan_petugas'];

    // Logika Upload Foto
    $bukti_nama = $_FILES['bukti_pengiriman']['name'];
    $bukti_final = "";

    if ($bukti_nama != "") {
        $tmp = $_FILES['bukti_pengiriman']['tmp_name'];
        $folder = "../uploads/";
        
        // Pastikan folder ada
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $nama_baru = time() . "_" . $bukti_nama; 
        if(move_uploaded_file($tmp, $folder . $nama_baru)){
            $bukti_final = $nama_baru;
        }
    }

    $query = "INSERT INTO DISTRIBUSI 
                (paket_id, penerima_id, mitra_id, tanggal_kirim, tanggal_terima, 
                 lokasi_pengiriman, status_pengiriman, bukti_pengiriman, catatan_petugas)
              VALUES 
                ('$paket_id', '$penerima_id', '$mitra_id', '$tanggal_kirim', '$tanggal_terima',
                 '$lokasi', '$status', '$bukti_final', '$catatan')";

    if (mysqli_query($koneksi_db, $query)) {
        echo "<script>alert('Data distribusi berhasil ditambahkan'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal tambah data: " . mysqli_error($koneksi_db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Tambah Distribusi</title>
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
<div class="relative flex min-h-screen w-full">

<div class="flex-shrink-0 w-64 bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-800 flex flex-col hidden lg:flex">
    <div class="flex flex-col flex-1 p-4 justify-between">
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" data-alt="Admin user avatar" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAsGJZc1kciEJL3XHhdEFPtu4-8hOiyPFywKFskA-qF2YFAivujmellxJFHWmNRjmCCR39a5Jmm0q3ub6682h2sZW96ia-_UoogkN_ExuLlmtbGeaCTc0hIlIrenjBPRji4DR4m8e1BPfpbebZIX_A7B1e6Sv7BYDtb2WejfDzEFvhqrhd6klCf-atyIHzS8jMxEKcnk-a0DNsBI0-bCU4dyqY6mdKmi3X_oCbEYCbKawqf4Vma9E7BnobFNjDuaBfo3irL-vuzzWjL");'></div>
                <div class="flex flex-col">
                    <h1 class="text-[#111418] dark:text-white text-base font-medium">Administrator</h1>
                    <p class="text-[#617589] dark:text-gray-400 text-sm">admin@portal.com</p>
                </div>
            </div>
            <nav class="flex flex-col gap-2 mt-4">
                <a class="flex items-center gap-3 px-3 py-2 rounded text-[#617589] dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" href="../index.php">
                    <span class="material-symbols-outlined">dashboard</span>
                    <p class="text-sm font-medium">Dashboard</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded text-[#617589] dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" href="../mitra/index.php">
                    <span class="material-symbols-outlined">handshake</span>
                    <p class="text-sm font-medium">Mitra</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded text-[#617589] dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" href="../user/index.php">
                    <span class="material-symbols-outlined">group</span>
                    <p class="text-sm font-medium">Pengguna</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded text-[#617589] dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" href="../penerima/index.php">
                    <span class="material-symbols-outlined">verified_user</span>
                    <p class="text-sm font-medium">Penerima</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary" href="index.php">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
                    <p class="text-sm font-medium">Distribusi</p>
                </a>
            </nav>
        </div>
    </div>
</div>

<main class="flex-1 p-8 overflow-y-auto">
<div class="max-w-4xl mx-auto">
    <div class="flex flex-wrap gap-2 mb-6">
        <a class="text-[#617589] dark:text-gray-400 text-base font-medium hover:text-primary" href="index.php">Distribusi</a>
        <span class="text-[#617589] dark:text-gray-400 text-base font-medium">/</span>
        <span class="text-[#111418] dark:text-white text-base font-medium">Tambah Distribusi</span>
    </div>

    <div class="flex flex-wrap justify-between gap-3 mb-8">
        <div class="flex min-w-72 flex-col gap-2">
            <h1 class="text-[#111418] dark:text-white text-4xl font-black tracking-tight">Tambah Distribusi</h1>
            <p class="text-[#617589] dark:text-gray-400 text-base font-normal">Lengkapi detail di bawah ini untuk menambahkan data distribusi baru.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
        
        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            
            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Paket Bantuan</p>
                    <select name="paket_id" class="form-select w-full rounded text-[#111418] dark:text-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:border-primary h-12 text-base px-4" required>
                        <option value="">-- Pilih Paket --</option>
                        <?php
                        $paket = mysqli_query($koneksi_db, "SELECT * FROM PAKETBANTUAN");
                        while ($p = mysqli_fetch_assoc($paket)) {
                            echo "<option value='{$p['paket_id']}'>{$p['nama_paket']} (Stok: {$p['kuantitas']})</option>";
                        }
                        ?>
                    </select>
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Penerima</p>
                    <select name="penerima_id" class="form-select w-full rounded text-[#111418] dark:text-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:border-primary h-12 text-base px-4" required>
                        <option value="">-- Pilih Penerima --</option>
                        <?php
                        $penerima = mysqli_query($koneksi_db, "SELECT * FROM PENERIMA");
                        while ($pr = mysqli_fetch_assoc($penerima)) {
                            echo "<option value='{$pr['penerima_id']}'>{$pr['nama_lengkap']}</option>";
                        }
                        ?>
                    </select>
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Mitra</p>
                    <select name="mitra_id" class="form-select w-full rounded text-[#111418] dark:text-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:border-primary h-12 text-base px-4" required>
                        <option value="">-- Pilih Mitra --</option>
                        <?php
                        $mitra = mysqli_query($koneksi_db, "SELECT * FROM MITRA");
                        while ($m = mysqli_fetch_assoc($mitra)) {
                            echo "<option value='{$m['mitra_id']}'>{$m['nama_mitra']}</option>";
                        }
                        ?>
                    </select>
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Tanggal Kirim</p>
                    <input type="date" name="tanggal_kirim" class="form-input w-full rounded text-[#111418] dark:text-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:border-primary h-12 px-4 text-base" />
                </label>
            </div>

            <div>
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Tanggal Terima</p>
                    <input type="date" name="tanggal_terima" class="form-input w-full rounded text-[#111418] dark:text-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:border-primary h-12 px-4 text-base" />
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Lokasi Pengiriman</p>
                    <input type="text" name="lokasi_pengiriman" class="form-input w-full rounded text-[#111418] dark:text-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:border-primary h-12 px-4 text-base" placeholder="Masukkan alamat lengkap" />
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Status Pengiriman</p>
                    <select name="status_pengiriman" class="form-select w-full rounded text-[#111418] dark:text-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:border-primary h-12 text-base px-4" required>
                        <option value="Dikemas">Dikemas</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Gagal">Gagal</option>
                    </select>
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Bukti Pengiriman</p>
                    <div class="flex justify-center items-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span class="material-symbols-outlined text-4xl text-gray-500 dark:text-gray-400">cloud_upload</span>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or JPEG</p>
                            </div>
                            <input name="bukti_pengiriman" type="file" class="hidden" accept="image/*" />
                        </label>
                    </div>
                </label>
            </div>

            <div class="md:col-span-2">
                <label class="flex flex-col">
                    <p class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Catatan Petugas</p>
                    <textarea name="catatan_petugas" class="form-textarea w-full rounded text-[#111418] dark:text-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 focus:border-primary h-24 px-4 py-3 text-base" placeholder="Tambahkan catatan..."></textarea>
                </label>
            </div>

            <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                <a href="index.php" class="px-6 py-3 rounded-lg text-sm font-semibold bg-gray-200 dark:bg-gray-700 text-[#111418] dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-3 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-blue-600 transition-colors">
                    Simpan Data
                </button>
            </div>

        </form>
        </div>
</div>
</main>
</div>
</body>
</html>