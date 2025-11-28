<?php
include "../config/koneksi.php";
$id = $_GET['id'];

// Perhatikan: Menghapus penerima tidak menghapus User (Parent)
mysqli_query($conn, "DELETE FROM PENERIMA WHERE penerima_id=$id");
echo "<script>alert('Data penerima berhasil dihapus'); window.location='index.php';</script>";
?>