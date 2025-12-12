<?php
include '../config/koneksi.php';

// Fix variabel koneksi
$koneksi_db = null;
if (isset($conn)) { $koneksi_db = $conn; } elseif (isset($koneksi)) { $koneksi_db = $koneksi; }

if (!$koneksi_db) {
    die("Error: Koneksi database tidak ditemukan.");
}

// Pastikan ID Paket ada
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$paket_id = $_GET['id'];
$query_paket = mysqli_query($koneksi_db, "SELECT * FROM PAKETBANTUAN WHERE paket_id = '$paket_id'");
$paket = mysqli_fetch_assoc($query_paket);

if (!$paket) {
    header("Location: index.php");
    exit;
}

// Ambil semua Item untuk Dropdown
$items_available = mysqli_query($koneksi_db, "SELECT * FROM ITEM ORDER BY nama_item ASC");

// Ambil Komposisi Paket saat ini
$details = mysqli_query($koneksi_db, "
    SELECT dp.detail_id, i.nama_item, i.satuan, dp.jumlah_per_paket, i.stok_gudang
    FROM DETAIL_PAKET dp
    JOIN ITEM i ON dp.item_id = i.item_id
    WHERE dp.paket_id = '$paket_id'
");
?>

<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Atur Komposisi Paket</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,0..200" rel="stylesheet"/>
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
          borderRadius: { "DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px" },
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
<div class="flex flex-grow">

<aside class="flex flex-col w-64 bg-white dark:bg-background-dark dark:border-r dark:border-gray-700 p-4 transition-all duration-300 hidden lg:flex">
    <div class="flex items-center gap-3 mb-8 p-2">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBMSuCqzhobnCaUbEdoyM6VHDrDCQEgxACBAfH9QUpSH_lbrV_l35SU0oDYtAaBXP9bU86jq3JTJgM-j0kEPcQGj7e13gN5pisyR3bTld18qN3FILkKRpLy6-80K7Bb-Fl9FeUfeuZv3x2IFPFw45TDPeMDBljZX0KiGKZ1cFPn7H78v6a-MGklw38yvyaXS19VttnaFCa71J8q6xdbGkzoeSHN_ZihCv_DGyHtcnoTN7GIw3vVTFOQxqoXKbQosAJjVXOLaf08Fiwv");'></div>
        <div class="flex flex-col">
            <h1 class="text-[#111418] dark:text-white text-base font-medium leading-normal">Administrator</h1>
            <p class="text-[#617589] dark:text-gray-400 text-sm font-normal leading-normal">admin@portal.com</p>
        </div>
    </div>
    <nav class="flex flex-col gap-2 flex-1">
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10 transition-colors" href="../index.php">
            <span class="material-symbols-outlined text-[#111418] dark:text-gray-300">dashboard</span>
            <p class="text-[#111418] dark:text-gray-300 text-sm font-medium leading-normal">Dashboard</p>
        </a>
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 dark:bg-primary/30" href="index.php">
            <span class="material-symbols-outlined text-primary dark:text-primary-300" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
            <p class="text-primary dark:text-primary-300 text-sm font-medium leading-normal">Paket Bantuan</p>
        </a>
    </nav>
</aside>

<main class="flex-1 p-8">
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <div class="flex flex-wrap gap-2 mb-4">
            <a class="text-[#617589] dark:text-gray-400 text-sm font-medium hover:text-primary" href="index.php">Paket Bantuan</a>
            <span class="text-[#617589] dark:text-gray-400 text-sm font-medium">/</span>
            <span class="text-[#111418] dark:text-white text-sm font-medium">Atur Komposisi</span>
        </div>
        <div class="flex justify-between items-center">
            <div>
                <p class="text-[#111418] dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Atur Komposisi Paket</p>
                <p class="text-[#617589] dark:text-gray-400 mt-2 text-lg">Paket: <span class="font-bold text-primary"><?= htmlspecialchars($paket['nama_paket']) ?></span></p>
            </div>
            <a href="index.php" class="px-6 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-[#111418] dark:text-white text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <?php if (isset($_GET['msg_type'])): ?>
        <?php
        $msg_type = $_GET['msg_type'];
        $msg = urldecode($_GET['msg']);
        $class = ($msg_type == 'success') ? 'bg-green-50 text-green-800 border-green-200' : 'bg-red-50 text-red-800 border-red-200';
        $icon = ($msg_type == 'success') ? 'check_circle' : 'error';
        ?>
        <div class="flex items-center p-4 mb-6 rounded-lg border <?= $class ?>">
            <span class="material-symbols-outlined mr-2"><?= $icon ?></span>
            <span class="text-sm font-medium"><?= htmlspecialchars($msg) ?></span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-background-dark dark:border dark:border-gray-700 p-6 rounded-xl shadow-sm h-full">
                <h3 class="text-xl font-bold text-[#111418] dark:text-white mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">add_box</span> Tambah Komponen
                </h3>
                
                <form method="POST" action="tambah_komposisi.php?id=<?= $paket_id ?>" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-[#111418] dark:text-gray-200 mb-2">Pilih Item Gudang</label>
                        <select name="item_id" class="form-select w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary" required>
                            <option value="">-- Pilih Item --</option>
                            <?php
                            mysqli_data_seek($items_available, 0);
                            while($i = mysqli_fetch_assoc($items_available)){
                                echo "<option value='{$i['item_id']}'>{$i['nama_item']} ({$i['satuan']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#111418] dark:text-gray-200 mb-2">Jumlah per Paket</label>
                        <input type="number" name="jumlah" step="0.01" min="0.01" class="form-input w-full rounded-lg border border-[#dbe0e6] dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111418] dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary" placeholder="0" required>
                    </div>
                    <button type="submit" name="tambah_item" class="w-full py-3 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90 transition-colors shadow-sm mt-4">
                        Tambahkan
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white dark:bg-background-dark dark:border dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-lg font-bold text-[#111418] dark:text-white">Daftar Komposisi Saat Ini</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-800/30">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Kebutuhan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Stok Gudang</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            <?php if(mysqli_num_rows($details) > 0) {
                                while($d = mysqli_fetch_assoc($details)): 
                                    $stok_status = $d['stok_gudang'] < $d['jumlah_per_paket'] ? 'text-red-600 font-bold' : 'text-gray-600 dark:text-gray-300';
                            ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-[#111418] dark:text-white"><?= htmlspecialchars($d['nama_item']) ?></td>
                                <td class="px-6 py-4 text-sm font-bold text-primary">
                                    <?= number_format($d['jumlah_per_paket'], 2) ?> <span class="text-xs font-normal text-gray-500"><?= htmlspecialchars($d['satuan']) ?></span>
                                </td>
                                <td class="px-6 py-4 text-sm <?= $stok_status ?>">
                                    <?= number_format($d['stok_gudang']) ?> <span class="text-xs font-normal text-gray-500"><?= htmlspecialchars($d['satuan']) ?></span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium flex justify-end gap-2">
                                    <a href="update_komposisi.php?id=<?= $paket_id ?>&detail_id=<?= $d['detail_id'] ?>" 
                                       class="text-primary hover:text-primary/80 transition-colors" title="Edit Jumlah">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </a>
                                    <a href="hapus_komposisi.php?id=<?= $paket_id ?>&detail_id=<?= $d['detail_id'] ?>" 
                                       class="text-red-500 hover:text-red-400 transition-colors" 
                                       onclick="return confirm('Hapus barang ini dari resep paket?')"
                                       title="Hapus Item">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; 
                            } else { ?>
                                <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">Paket ini belum memiliki komposisi. Silakan tambahkan item.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</main>
</div>
</div>
</body>
</html>