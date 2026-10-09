<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

if (!isset($_GET['kd_barang']) || empty($_GET['kd_barang'])) {
    die("Kode barang tidak diberikan.");
}

$kd_barang = pg_escape_string($conn, $_GET['kd_barang']);
$sql = "DELETE FROM tb_barang WHERE kd_barang = '$kd_barang'";
if (pg_query($conn, $sql)) {
    header("Location: data_barang.php");
    exit();
} else {
    echo "Error: " . pg_last_error($conn);
}
?>