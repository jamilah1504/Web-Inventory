<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

if (!isset($_GET['id_customer']) || empty($_GET['id_customer'])) {
    die("ID customer tidak diberikan.");
}

$id_customer = pg_escape_string($conn, $_GET['id_customer']);
$sql = "DELETE FROM tb_customer WHERE id_customer = '$id_customer'";
if (pg_query($conn, $sql)) {
    header("Location: data_customer.php");
    exit();
} else {
    echo "Error: " . pg_last_error($conn);
}
?>