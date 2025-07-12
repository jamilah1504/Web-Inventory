<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id_keluar']) || empty($_GET['id_keluar'])) {
    die("ID keluar tidak diberikan.");
}

$id_keluar = mysqli_real_escape_string($conn, $_GET['id_keluar']);
$sql = "DELETE FROM stok_keluar WHERE id_keluar = '$id_keluar'";
if (mysqli_query($conn, $sql)) {
    header("Location: daftar_permintaan.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>