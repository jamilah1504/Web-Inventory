<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

if (!isset($_GET['no_penjualan']) || empty($_GET['no_penjualan'])) {
    die("No penjualan tidak diberikan.");
}

$no_penjualan = pg_escape_string($conn, $_GET['no_penjualan']);
$sql = "DELETE FROM tb_penjualan WHERE no_penjualan = '$no_penjualan'";
if (pg_query($conn, $sql)) {
    header("Location: detail_penjualan.php");
    exit();
} else {
    echo "Error: " . pg_last_error($conn);
}
?>