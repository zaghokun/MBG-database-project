<?php
include "../config/koneksi.php";
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM USER WHERE user_id=$id");
echo "<script>alert('User berhasil dihapus'); window.location='index.php';</script>";
?>
