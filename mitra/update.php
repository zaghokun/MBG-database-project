<?php 
// 1. Integrasi Koneksi Database & Ambil Data
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

// Ambil ID dari URL
$id = $_GET['id'];

// Proses Update Data
if(isset($_POST['update'])){
    $user_id = $_POST['user_id'];
    $nama_mitra = $_POST['nama_mitra'];
    $jenis_mitra = $_POST['jenis_mitra'];
    $kontak_person = $_POST['kontak_person'];
    $no_hp = $_POST['no_hp'];
    $alamat_mitra = $_POST['alamat_mitra'];
    $wilayah_operasional = $_POST['wilayah_operasional'];

    $query_update = "UPDATE MITRA SET 
        user_id='$user_id',
        nama_mitra='$nama_mitra',
        jenis_mitra='$jenis_mitra',
        kontak_person='$kontak_person',
        no_hp='$no_hp',
        alamat_mitra='$alamat_mitra',
        wilayah_operasional='$wilayah_operasional'
        WHERE mitra_id=$id";

    if(mysqli_query($koneksi_db, $query_update)){
        echo "<script>alert('Data mitra berhasil diupdate'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal update data: " . mysqli_error($koneksi_db) . "');</script>";
    }
}

// Ambil Data Mitra untuk ditampilkan di form
$query_data = mysqli_query($koneksi_db, "SELECT * FROM MITRA WHERE mitra_id=$id");
$data = mysqli_fetch_assoc($query_data);

// Cek apakah data ditemukan
if (!$data) {
    die("Data mitra tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Data Mitra</title>
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
                fontFamily: { "display": ["Inter", "sans-serif"] },
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
<div class="flex h-full grow">

<aside class="flex-shrink-0 w-64 bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-800 hidden lg:block">
    <div class="flex h-full flex-col justify-between p-4">
        <div class="flex flex-col gap-4">
            <div class="flex gap-3 items-center px-2">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAbW23s2Z0YxlCVkQGJ2eKJPalgIMrOhZ-ipS8dkE_6HfAS7iu9x-zqdcl8ymAnCT--nz01PmYa5OltIe-TSWEE0Onlxil73CsrJwLq6n9MD4eeBxH1MjlEfiIaL68v10SUyBbItQ7YcABfqvUEBBTzlZ9RcHmO3ap6lebb5kNxH9xIYruBE5fzl8UU8ryjVh94ddMMT1QW_KateAFiJ0sefsrUSta8buhXgzKHMQu4Zlbn3wswjoFPHD4Rt4UuYGFrmtwOUalKaxsI");'></div>
                <div class="flex flex-col">
                    <h1 class="text-gray-900 dark:text-white text-base font-medium">Administrator</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">admin@portal.com</p>
                </div>
            </div>
            <nav class="flex flex-col gap-2 mt-4">
                <a href="../index.php" class="flex items-center gap-3 px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 rounded-lg">
                    <span class="material-symbols-outlined">dashboard</span>
                    <p class="text-sm font-medium">Dashboard</p>
                </a>
                <a href="index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">handshake</span>
                    <p class="text-sm font-medium">Data Mitra</p>
                </a>
            </nav>
        </div>
    </div>
</aside>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    <div class="flex flex-wrap gap-2 mb-4">
        <a class="text-gray-500 dark:text-gray-400 text-sm font-medium hover:text-primary" href="index.php">Data Mitra</a>
        <span class="text-gray-500 dark:text-gray-400 text-sm font-medium">/</span>
        <span class="text-gray-900 dark:text-white text-sm font-medium">Edit Data Mitra</span>
    </div>

    <div class="flex flex-wrap justify-between gap-3 mb-8">
        <p class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Edit Data Mitra</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-8">
        
        <form method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div class="flex flex-col md:col-span-2">
                    <label class="text-gray-800 dark:text-gray-200 text-sm font-medium pb-2">Akun User Penanggung Jawab</label>
                    <select name="user_id" class="form-select w-full rounded-lg text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-3 text-base" required>
                        <?php
                        $user_qry = mysqli_query($koneksi_db, "SELECT * FROM USER");
                        while($u = mysqli_fetch_assoc($user_qry)){
                            $selected = ($u['user_id'] == $data['user_id']) ? "selected" : "";
                            echo "<option value='".$u['user_id']."' $selected>".$u['nama']." (".$u['role'].")</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-800 dark:text-gray-200 text-sm font-medium pb-2">Nama Mitra</label>
                    <input type="text" name="nama_mitra" value="<?= htmlspecialchars($data['nama_mitra']) ?>" class="form-input w-full rounded-lg text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-3 text-base" required />
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-800 dark:text-gray-200 text-sm font-medium pb-2">Jenis Mitra</label>
                    <input type="text" name="jenis_mitra" value="<?= htmlspecialchars($data['jenis_mitra']) ?>" class="form-input w-full rounded-lg text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-3 text-base" />
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-800 dark:text-gray-200 text-sm font-medium pb-2">Kontak Person (PIC)</label>
                    <input type="text" name="kontak_person" value="<?= htmlspecialchars($data['kontak_person']) ?>" class="form-input w-full rounded-lg text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-3 text-base" />
                </div>

                <div class="flex flex-col">
                    <label class="text-gray-800 dark:text-gray-200 text-sm font-medium pb-2">No HP</label>
                    <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']) ?>" class="form-input w-full rounded-lg text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-3 text-base" />
                </div>

                <div class="flex flex-col md:col-span-2">
                    <label class="text-gray-800 dark:text-gray-200 text-sm font-medium pb-2">Wilayah Operasional</label>
                    <input type="text" name="wilayah_operasional" value="<?= htmlspecialchars($data['wilayah_operasional']) ?>" class="form-input w-full rounded-lg text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 h-12 px-3 text-base" />
                </div>

                <div class="flex flex-col md:col-span-2">
                    <label class="text-gray-800 dark:text-gray-200 text-sm font-medium pb-2">Alamat Mitra</label>
                    <textarea name="alamat_mitra" class="form-textarea w-full rounded-lg text-gray-900 dark:text-white border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-base" rows="4"><?= htmlspecialchars($data['alamat_mitra']) ?></textarea>
                </div>

            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-800">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-sm font-semibold bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Kembali
                </a>
                <button type="submit" name="update" class="px-6 py-2.5 rounded-lg text-sm font-semibold bg-primary text-white hover:bg-primary/90 transition-colors">
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