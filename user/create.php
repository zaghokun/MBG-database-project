<?php 
// 1. Integrasi Koneksi Database & Logika Simpan
include "../config/koneksi.php"; 

// Fix variabel koneksi
$koneksi_db = null;
if (isset($conn)) {
    $koneksi_db = $conn;
} elseif (isset($koneksi)) {
    $koneksi_db = $koneksi;
}

// Logika Simpan Data
if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    // Hash password untuk keamanan
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $no_hp = $_POST['no_hp'];
    $tanggal_daftar = date('Y-m-d');
    $status_akun = $_POST['status_akun'];

    $query = "INSERT INTO USER VALUES (NULL, '$nama', '$email', '$password', '$role', '$no_hp', '$tanggal_daftar', NULL, '$status_akun')";
    
    if(mysqli_query($koneksi_db, $query)){
        echo "<script>alert('User berhasil ditambahkan'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan user: " . mysqli_error($koneksi_db) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Tambah Pengguna Baru</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
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

<div class="flex flex-col gap-4 border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-background-dark p-4 w-64 hidden lg:flex">
    <div class="flex items-center gap-3 px-3 py-2">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAxeuKUAQ_wskUxkEhnVs4z8j0aP1OtXvQ1P59r98qnhl-1npCmvnvR1x1KNUhTq_w8_FC6paJSnh8jyzUj8jWITi4ppZLLXP_iNUSvXZsBl3hPyf-0gwn0w8F4hMbsGv1bSa1Plg_NF2Kc3y2Oitzr_s41azmgiSu02N1jUw-MBAwrqU2d9V-o2mFMzJdEFD8bjW8Z9xFly3O5PXPjzy3SZmsO5ZSaRFJv9Hy0Jbj-vPKMqXXMwR01IXDWQzU058HaxLSuXwCz5dJt');"></div>
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
            <a href="../mitra/index.php" class="flex items-center gap-3 px-3 py-2 text-[#111418] dark:text-gray-300 hover:bg-gray-100 rounded-lg">
                <span class="material-symbols-outlined">handshake</span>
                <p class="text-sm font-medium">Mitra</p>
            </a>
            <a href="index.php" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">person</span>
                <p class="text-sm font-medium">Pengguna</p>
            </a>
            <a href="../penerima/index.php" class="flex items-center gap-3 px-3 py-2 text-[#111418] dark:text-gray-300 hover:bg-gray-100 rounded-lg">
                <span class="material-symbols-outlined">groups</span>
                <p class="text-sm font-medium">Penerima</p>
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
    <div class="flex flex-wrap gap-2 mb-4">
        <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="../index.php">Dashboard</a>
        <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
        <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="index.php">Pengguna</a>
        <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
        <span class="text-[#111418] dark:text-white text-sm font-medium">Tambah Baru</span>
    </div>

    <div class="flex flex-wrap justify-between gap-3 mb-8">
        <p class="text-[#111418] dark:text-white text-3xl font-bold tracking-tight">Tambah Pengguna Baru</p>
    </div>

    <div class="bg-white dark:bg-background-dark p-8 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        
        <form method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-input flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-sm" placeholder="Masukkan nama lengkap" required />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Email</label>
                    <input type="email" name="email" class="form-input flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-sm" placeholder="email@contoh.com" required />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Password</label>
                    <input type="password" name="password" class="form-input flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-sm" placeholder="Masukkan password aman" required />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Role</label>
                    <select name="role" class="form-select flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-sm">
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">No HP</label>
                    <input type="text" name="no_hp" class="form-input flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-sm" placeholder="08xxxxxxxxxx" />
                </div>

                <div class="flex flex-col">
                    <label class="text-[#111418] dark:text-gray-200 text-sm font-medium pb-2">Status Akun</label>
                    <select name="status_akun" class="form-select flex w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white focus:ring-2 focus:ring-primary h-12 px-4 text-sm">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-4 pt-8 mt-8 border-t border-gray-200 dark:border-gray-700">
                <a href="index.php" class="px-6 py-2.5 rounded-lg text-sm font-semibold bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">
                    Kembali
                </a>
                <button type="submit" name="simpan" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-white bg-primary hover:bg-primary/90 transition-colors">
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