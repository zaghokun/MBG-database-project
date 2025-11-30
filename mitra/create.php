<?php
// 1. Integrasi Koneksi Database
include '../config/koneksi.php';

// Fix variabel koneksi (Menangani $conn atau $koneksi)
$koneksi_db = null;
if (isset($conn)) {
    $koneksi_db = $conn;
} elseif (isset($koneksi)) {
    $koneksi_db = $koneksi;
}

if (!$koneksi_db) {
    die("Error: Variabel koneksi database tidak ditemukan.");
}

// 2. Logika Simpan Data (INSERT)
// Hanya berjalan jika tombol 'simpan' ditekan
if (isset($_POST['simpan'])) {
    $user_id             = $_POST['user_id'];
    $nama_mitra          = $_POST['nama_mitra'];
    $jenis_mitra         = $_POST['jenis_mitra'];
    $kontak_person       = $_POST['kontak_person'];
    $no_hp               = $_POST['no_hp'];
    $alamat_mitra        = $_POST['alamat_mitra'];
    $wilayah_operasional = $_POST['wilayah_operasional'];

    $query = "INSERT INTO MITRA 
              (mitra_id, user_id, nama_mitra, jenis_mitra, kontak_person, no_hp, alamat_mitra, wilayah_operasional) 
              VALUES 
              (NULL, '$user_id', '$nama_mitra', '$jenis_mitra', '$kontak_person', '$no_hp', '$alamat_mitra', '$wilayah_operasional')";

    if (mysqli_query($koneksi_db, $query)) {
        echo "<script>alert('Data mitra berhasil ditambahkan'); window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan data: " . mysqli_error($koneksi_db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Tambah Mitra Baru</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
</style>
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
        },
    },
    }
</script>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="flex min-h-screen">

<div class="flex-shrink-0 w-64 bg-white dark:bg-background-dark border-r border-gray-200 dark:border-gray-800 hidden lg:block">
    <div class="flex h-full flex-col justify-between p-4">
        <div class="flex flex-col gap-4">
            <div class="flex gap-3 items-center px-3 py-2">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAP8naGXIjLQOumwWP6b0-rW9gJOPqIzfKTaQJSOECvRoeMsC5KjlDEau0mQOQezUaSvAoK8iGRc0429GuGAncXUj9-fEYonxJLzS5Up7acXNfUSe2-hglmuCR4XJTMc4gqwviw80jLvXiqTB34NSH0jS9Lf9-3cNri7o6ntTD9WqoZLLc4rd5w96NU6RuNw0sJMQYoMeSQAD2J2FVwUhIEmN1E0xPZqVEEOks-nmCxlp3qQ6KhWL01G_lriUvjwfOCS2EFTdpxk_Zm");'></div>
                <div class="flex flex-col">
                    <h1 class="text-[#111418] dark:text-white text-base font-medium">Admin</h1>
                    <p class="text-[#617589] dark:text-gray-400 text-sm">admin@portal.com</p>
                </div>
            </div>
            <div class="flex flex-col gap-2 mt-4">
                <a href="../index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary/10 dark:hover:bg-primary/20 hover:text-primary">
                    <span class="material-symbols-outlined">dashboard</span>
                    <p class="text-sm font-medium">Dashboard</p>
                </a>
                <a href="index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">handshake</span>
                    <p class="text-sm font-medium">Mitra</p>
                </a>
                <a href="../user/index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary/10 dark:hover:bg-primary/20 hover:text-primary">
                    <span class="material-symbols-outlined">group</span>
                    <p class="text-sm font-medium">Pengguna</p>
                </a>
                <a href="../penerima/index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary/10 dark:hover:bg-primary/20 hover:text-primary">
                    <span class="material-symbols-outlined">accessibility_new</span>
                    <p class="text-sm font-medium">Penerima</p>
                </a>
                <a href="../paketbantuan/index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-primary/10 dark:hover:bg-primary/20 hover:text-primary">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <p class="text-sm font-medium">Bantuan</p>
                </a>
            </div>
        </div>
    </div>
</div>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    <div class="flex flex-wrap justify-between gap-3 pb-6">
        <h1 class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Tambah Mitra Baru</h1>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-8 border border-gray-200 dark:border-gray-800">
        <h2 class="text-[#111418] dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] pb-6 border-b border-gray-200 dark:border-gray-700">Detail Mitra</h2>

        <form method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-6">
                
                <div class="flex flex-col min-w-40 flex-1 col-span-2">
                    <label class="text-[#111418] dark:text-gray-200 text-base font-medium pb-2">Akun User Penanggung Jawab</label>
                    <select name="user_id" class="form-select w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-gray-800 h-14 px-4 py-3 text-base" required>
                        <option value="">-- Pilih User --</option>
                        <?php
                        $user_qry = mysqli_query($koneksi_db, "SELECT * FROM USER");
                        while ($u = mysqli_fetch_assoc($user_qry)) {
                            echo "<option value='" . $u['user_id'] . "'>" . $u['nama'] . " (" . $u['role'] . ")</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="flex flex-col min-w-40 flex-1">
                    <label class="text-[#111418] dark:text-gray-200 text-base font-medium pb-2">Nama Mitra</label>
                    <input type="text" name="nama_mitra" class="form-input w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-gray-800 h-14 px-4 py-3 text-base" placeholder="Nama Perusahaan/Instansi" required />
                </div>

                <div class="flex flex-col min-w-40 flex-1">
                    <label class="text-[#111418] dark:text-gray-200 text-base font-medium pb-2">Jenis Mitra</label>
                    <input type="text" name="jenis_mitra" class="form-input w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-gray-800 h-14 px-4 py-3 text-base" placeholder="Contoh: Supplier, NGO, Pemerintah" required />
                </div>

                <div class="flex flex-col min-w-40 flex-1">
                    <label class="text-[#111418] dark:text-gray-200 text-base font-medium pb-2">Kontak Person (PIC)</label>
                    <input type="text" name="kontak_person" class="form-input w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-gray-800 h-14 px-4 py-3 text-base" placeholder="Masukkan nama PIC" />
                </div>

                <div class="flex flex-col min-w-40 flex-1">
                    <label class="text-[#111418] dark:text-gray-200 text-base font-medium pb-2">No HP</label>
                    <input type="tel" name="no_hp" class="form-input w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-gray-800 h-14 px-4 py-3 text-base" placeholder="08xxxxxxxxxx" />
                </div>

                <div class="flex flex-col min-w-40 flex-1 col-span-2">
                    <label class="text-[#111418] dark:text-gray-200 text-base font-medium pb-2">Alamat Mitra</label>
                    <textarea name="alamat_mitra" class="form-textarea w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-gray-800 h-28 px-4 py-3 text-base" placeholder="Masukkan alamat lengkap mitra"></textarea>
                </div>

                <div class="flex flex-col min-w-40 flex-1 col-span-2">
                    <label class="text-[#111418] dark:text-gray-200 text-base font-medium pb-2">Wilayah Operasional</label>
                    <input type="text" name="wilayah_operasional" class="form-input w-full rounded-lg text-[#111418] dark:text-white border border-[#dbe0e6] dark:border-gray-700 bg-white dark:bg-gray-800 h-14 px-4 py-3 text-base" placeholder="Contoh: Jawa Tengah, Nasional" />
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="index.php" class="px-6 py-3 rounded-lg text-[#111418] dark:text-white bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-base font-medium">
                    Kembali
                </a>
                <button type="submit" name="simpan" class="px-6 py-3 rounded-lg text-white bg-primary hover:bg-primary/90 text-base font-medium">
                    Simpan Data
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