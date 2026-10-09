<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

if (!isset($_GET['id_keluar']) || empty($_GET['id_keluar'])) {
    die("ID keluar tidak diberikan.");
}

$id_keluar = pg_escape_string($conn, $_GET['id_keluar']);
$sql = "DELETE FROM stok_keluar WHERE id_keluar = '$id_keluar'";
if (pg_query($conn, $sql)) {
    header("Location: daftar_permintaan.php");
    exit();
} else {
    echo "Error: " . pg_last_error($conn);
}
?>