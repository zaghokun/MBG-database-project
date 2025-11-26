<?php
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete = mysqli_query($conn, "DELETE FROM paketbantuan WHERE paket_id='$id'");

    if ($delete) {
        // kirim status sukses ke halaman index
        header("Location: index.php?msg=deleted");
        exit;
    } else {
        header("Location: index.php?msg=error");
        exit;
    }
}
?>
