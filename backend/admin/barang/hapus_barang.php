<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['kd_barang']) || empty($_GET['kd_barang'])) {
    die("Kode barang tidak diberikan.");
}

$kd_barang = mysqli_real_escape_string($conn, $_GET['kd_barang']);
$sql = "DELETE FROM tb_barang WHERE kd_barang = '$kd_barang'";
if (mysqli_query($conn, $sql)) {
    header("Location: data_barang.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>