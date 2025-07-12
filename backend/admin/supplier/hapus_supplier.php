<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id_supplier']) || empty($_GET['id_supplier'])) {
    die("ID supplier tidak diberikan.");
}

$id_supplier = mysqli_real_escape_string($conn, $_GET['id_supplier']);
$sql = "DELETE FROM tb_supplier WHERE id_supplier = '$id_supplier'";
if (mysqli_query($conn, $sql)) {
    header("Location: data_supplier.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>