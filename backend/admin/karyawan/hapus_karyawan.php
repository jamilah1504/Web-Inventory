<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id_karyawan']) || empty($_GET['id_karyawan'])) {
    die("ID karyawan tidak diberikan.");
}

$id_karyawan = mysqli_real_escape_string($conn, $_GET['id_karyawan']);
$sql = "DELETE FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'";
if (mysqli_query($conn, $sql)) {
    header("Location: data_karyawan.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>