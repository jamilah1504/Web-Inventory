<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id_kategori']) || empty($_GET['id_kategori'])) {
    die("ID kategori tidak diberikan.");
}

$id_kategori = mysqli_real_escape_string($conn, $_GET['id_kategori']);
$sql = "DELETE FROM kategori_barang WHERE id_kategori = '$id_kategori'";
if (mysqli_query($conn, $sql)) {
    header("Location: data_kategori.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>