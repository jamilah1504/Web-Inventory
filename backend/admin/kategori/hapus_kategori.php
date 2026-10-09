<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

if (!isset($_GET['id_kategori']) || empty($_GET['id_kategori'])) {
    die("ID kategori tidak diberikan.");
}

$id_kategori = pg_escape_string($conn, $_GET['id_kategori']);
$sql = "DELETE FROM kategori_barang WHERE id_kategori = '$id_kategori'";
if (pg_query($conn, $sql)) {
    header("Location: data_kategori.php");
    exit();
} else {
    echo "Error: " . pg_last_error($conn);
}
?>