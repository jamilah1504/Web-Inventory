<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

if (!isset($_GET['no_pembelian']) || empty($_GET['no_pembelian'])) {
    die("No pembelian tidak diberikan.");
}

$no_pembelian = pg_escape_string($conn, $_GET['no_pembelian']);
$sql = "DELETE FROM tb_pembelian WHERE no_pembelian = '$no_pembelian'";
if (pg_query($conn, $sql)) {
    header("Location: transaksi_pembelian.php");
    exit();
} else {
    echo "Error: " . pg_last_error($conn);
}
?>