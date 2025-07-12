<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['no_pembelian']) || empty($_GET['no_pembelian'])) {
    die("No pembelian tidak diberikan.");
}

$no_pembelian = mysqli_real_escape_string($conn, $_GET['no_pembelian']);
$sql = "DELETE FROM tb_pembelian WHERE no_pembelian = '$no_pembelian'";
if (mysqli_query($conn, $sql)) {
    header("Location: transaksi_pembelian.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>