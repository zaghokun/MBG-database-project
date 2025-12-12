<?php
include '../config/koneksi.php';
$koneksi_db = (isset($conn)) ? $conn : $koneksi;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Hapus data (Relasi ON DELETE CASCADE di database akan otomatis menghapus detail paket yang pakai item ini)
    if (mysqli_query($koneksi_db, "DELETE FROM ITEM WHERE item_id='$id'")) {
        header("Location: index.php?msg=deleted");
    } else {
        echo "Gagal menghapus data.";
    }
}
?>