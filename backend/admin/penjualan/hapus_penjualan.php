<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['no_penjualan']) || empty($_GET['no_penjualan'])) {
    die("No penjualan tidak diberikan.");
}

$no_penjualan = mysqli_real_escape_string($conn, $_GET['no_penjualan']);
$sql = "DELETE FROM tb_penjualan WHERE no_penjualan = '$no_penjualan'";
if (mysqli_query($conn, $sql)) {
    header("Location: detail_penjualan.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>