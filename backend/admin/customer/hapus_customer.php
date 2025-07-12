<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id_customer']) || empty($_GET['id_customer'])) {
    die("ID customer tidak diberikan.");
}

$id_customer = mysqli_real_escape_string($conn, $_GET['id_customer']);
$sql = "DELETE FROM tb_customer WHERE id_customer = '$id_customer'";
if (mysqli_query($conn, $sql)) {
    header("Location: data_customer.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
?>