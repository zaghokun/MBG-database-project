<?php
include '../config/koneksi.php';

// Fix variabel koneksi
$koneksi_db = null;
if (isset($conn)) { $koneksi_db = $conn; } elseif (isset($koneksi)) { $koneksi_db = $koneksi; }
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gudang Logistik</title>
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
                    fontFamily: {
                        "display": ["Inter"]
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
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" href="../item/index.php">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">warehouse</span>
            <p class="text-sm font-medium">Gudang Item</p>
        </a>
    </nav>
    <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 text-sm font-bold">
        <span class="material-symbols-outlined mr-2">logout</span> Logout
    </button>
</div>
</aside>

<main class="flex-1 p-6 lg:p-10">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row flex-wrap justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex flex-col gap-1">
                <h1 class="text-[#111418] dark:text-white text-3xl font-black">Gudang Logistik</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Kelola stok barang mentah (Beras, Minyak, dll).</p>
            </div>
            <a href="create.php" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-5 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined mr-2 text-base">add</span>
                <span class="truncate">Tambah Item</span>
            </a>
        </div>

        <?php if (isset($_GET['msg'])) : ?>
            <div class="mb-6">
                <?php if ($_GET['msg'] == 'deleted') : ?>
                    <div class="flex items-center p-4 text-green-800 bg-green-50 rounded-lg border border-green-200">
                        <span class="material-symbols-outlined mr-2">check_circle</span> Item berhasil dihapus.
                    </div>
                <?php elseif ($_GET['msg'] == 'updated') : ?>
                    <div class="flex items-center p-4 text-yellow-800 bg-yellow-50 rounded-lg border border-yellow-200">
                        <span class="material-symbols-outlined mr-2">info</span> Item berhasil diperbarui.
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white dark:bg-background-dark rounded-xl shadow-sm overflow-hidden border border-gray-200 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Nama Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Satuan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Stok</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi_db, "SELECT * FROM ITEM ORDER BY item_id DESC");
                        while ($row = mysqli_fetch_assoc($query)) : 
                            $stok_class = $row['stok_gudang'] < 10 ? 'text-red-600 font-bold' : 'text-gray-600 dark:text-gray-300';
                        ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400"><?= $no++ ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($row['nama_item']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs"><?= htmlspecialchars($row['satuan']) ?></span>
                            </td>
                            <td class="px-6 py-4 text-sm <?= $stok_class ?>">
                                <?= number_format($row['stok_gudang']) ?>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                <a href="update.php?id=<?= $row['item_id'] ?>" class="inline-flex p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </a>
                                <a href="delete.php?id=<?= $row['item_id'] ?>" onclick="return confirm('Hapus item ini?')" class="inline-flex p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400 hover:text-red-500 transition-colors">
                                    <span class="material-symbols-outlined text-base">delete</span>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
</div>
</div>
</body>
</html>