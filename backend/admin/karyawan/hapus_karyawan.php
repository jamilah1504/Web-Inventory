<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

if (!isset($_GET['id_karyawan']) || empty($_GET['id_karyawan'])) {
    die("ID karyawan tidak diberikan.");
}

$id_karyawan = pg_escape_string($conn, $_GET['id_karyawan']);
$sql = "DELETE FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'";
if (pg_query($conn, $sql)) {
    header("Location: data_karyawan.php");
    exit();
} else {
    echo "Error: " . pg_last_error($conn);
}
?>