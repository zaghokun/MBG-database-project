<?php
include '../config/koneksi.php';
$koneksi_db = (isset($conn)) ? $conn : $koneksi;

if (!isset($_GET['id']) || !isset($_GET['detail_id'])) {
    header("Location: index.php");
    exit;
}

$paket_id = $_GET['id'];
$detail_id = $_GET['detail_id'];

$delete = mysqli_query($koneksi_db, "DELETE FROM DETAIL_PAKET WHERE detail_id = '$detail_id'");

if ($delete) {
    header("Location: komposisi.php?id=$paket_id&msg_type=success&msg=".urlencode("Item berhasil dihapus"));
} else {
    header("Location: komposisi.php?id=$paket_id&msg_type=error&msg=".urlencode("Gagal menghapus item"));
}
?>