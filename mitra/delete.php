<?php
include "../config/koneksi.php";
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM MITRA WHERE mitra_id=$id");
echo "<script>alert('Data mitra berhasil dihapus'); window.location='index.php';</script>";
?>