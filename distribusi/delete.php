<?php
include '../config/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$distribusi_id = $_GET['id'];

// Ambil data untuk cek file
$data = mysqli_query($conn, "SELECT bukti_pengiriman FROM DISTRIBUSI WHERE distribusi_id = '$distribusi_id'");
$row = mysqli_fetch_assoc($data);

if ($row) {
    $folder = "../uploads/";

    // Hapus foto jika ada dan file-nya masih ada
    if ($row['bukti_pengiriman'] != "" && file_exists($folder . $row['bukti_pengiriman'])) {
        unlink($folder . $row['bukti_pengiriman']);
    }

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM distribusi WHERE distribusi_id = '$distribusi_id'");
}

header("Location: index.php?delete=success");
exit;
?>
