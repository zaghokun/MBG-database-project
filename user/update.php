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
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $no_hp = $_POST['no_hp'];
    $status_akun = $_POST['status_akun'];

    $query_update = "UPDATE USER SET 
        nama='$nama',
        email='$email',
        role='$role',
        no_hp='$no_hp',
        status_akun='$status_akun'
        WHERE user_id=$id";

    if(mysqli_query($koneksi_db, $query_update)){
        echo "<script>alert('Data user berhasil diupdate'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal update data: " . mysqli_error($koneksi_db) . "');</script>";
    }
}

// Ambil Data User untuk ditampilkan di form
$query_data = mysqli_query($koneksi_db, "SELECT * FROM USER WHERE user_id=$id");
$data = mysqli_fetch_assoc($query_data);

// Cek apakah data ditemukan
if (!$data) {
    die("Data user tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Edit Pengguna</title>
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
<div class="flex min-h-screen">

<div class="flex flex-col gap-4 border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-4 w-64 hidden lg:flex">
    <div class="flex items-center gap-3 px-3 py-2">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBq1fIAHTsmdIfmjZsKv2iOnvvtJkbmWVslAaWYAFYRe057sbJQyjig3069dhJYkYg6Umj76pLQWtDCw_BdWmEEPn1Bf2Jz1GW8Q77IgFDB9_Hov4Kdf0lEr4pN7RSasQ-4OSfFZOK6zYufx0RcOAtXAT-E2a37138qNboCjEJFzMP6tvpZME5yHECIFkC6DYlTUfWlJczZQMtf96qiN9bSjwQzo1VPa9NuQZqqNIZyMa2RUrYv4vfjOXqTTMTVyC2ZsG2jh6LBsotr');"></div>
        <div class="flex flex-col">
            <h1 class="text-[#111418] dark:text-white text-base font-medium">Administrator</h1>
            <p class="text-[#617589] dark:text-gray-400 text-sm">admin@portal.com</p>
        </div>
    </div>
    <div class="flex h-full flex-col justify-between">
        <div class="flex flex-col gap-2 mt-4">
            <a href="../index.php" class="flex items-center gap-3 px-3 py-2 text-[#111418] dark:text-gray-300 hover:bg-gray-100 rounded-lg">
                <span class="material-symbols-outlined">dashboard</span>
                <p class="text-sm font-medium">Dashboard</p>
            </a>
            <a href="index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
                <p class="text-sm font-medium">Pengguna</p>
            </a>
        </div>
        <div class="flex flex-col gap-1">
            <a href="#" class="flex items-center gap-3 px-3 py-2 text-[#111418] dark:text-gray-300 hover:bg-gray-100 rounded-lg">
                <span class="material-symbols-outlined">logout</span>
                <p class="text-sm font-medium">Logout</p>
            </a>
        </div>
    </div>
</div>

<main class="flex-1 p-8">
<div class="max-w-4xl mx-auto">
    <div class="flex flex-wrap gap-2 mb-6">
        <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="../index.php">Dashboard</a>
        <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
        <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="index.php">Pengguna</a>
        <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
        <span class="text-[#111418] dark:text-white text-sm font-medium">Edit Pengguna</span>
    </div>

    <div class="flex flex-wrap justify-between gap-3 mb-8">
        <div class="flex flex-col gap-2">
            <p class="text-[#111418] dark:text-white text-3xl font-black tracking-tight">Edit Pengguna</p>
            <p class="text-[#617589] dark:text-gray-400 text-base font-normal">Perbarui informasi detail pengguna yang dipilih.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-background-dark/50 p-6 md:p-8 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            
            <div class="flex flex-col">
                <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="form-input flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-base" required />
            </div>

            <div class="flex flex-col">
                <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" class="form-input flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-base" required />
            </div>

            <div class="flex flex-col">
                <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Role</label>
                <div class="relative">
                    <select name="role" class="form-select w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-base">
                        <option value="admin" <?= ($data['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="staff" <?= ($data['role'] == 'staff') ? 'selected' : '' ?>>Staff</option>
                        <option value="user" <?= ($data['role'] == 'user') ? 'selected' : '' ?>>User</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col">
                <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">No HP</label>
                <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']) ?>" class="form-input flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-base" />
            </div>

            <div class="flex flex-col md:col-span-2">
                <label class="text-[#111418] dark:text-white text-sm font-medium pb-2">Status Akun</label>
                <div class="relative">
                    <select name="status_akun" class="form-select w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-base">
                        <option value="Aktif" <?= ($data['status_akun'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                        <option value="Nonaktif" <?= ($data['status_akun'] == 'Nonaktif' || $data['status_akun'] == 'Tidak Aktif') ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 md:col-span-2 pt-4">
                <a href="index.php" class="flex items-center justify-center gap-2 h-11 px-6 rounded-lg text-[#111418] dark:text-white text-sm font-semibold bg-gray-200/80 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 transition-colors">
                    Kembali
                </a>
                <button type="submit" name="update" class="flex items-center justify-center gap-2 h-11 px-6 rounded-lg text-white text-sm font-semibold bg-primary hover:bg-primary/90 transition-colors">
                    Update Data
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