<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

if (!isset($_GET['id_supplier']) || empty($_GET['id_supplier'])) {
    die("ID supplier tidak diberikan.");
}

$id_supplier = pg_escape_string($conn, $_GET['id_supplier']);
$sql = "DELETE FROM tb_supplier WHERE id_supplier = '$id_supplier'";
if (pg_query($conn, $sql)) {
    header("Location: data_supplier.php");
    exit();
} else {
    echo "Error: " . pg_last_error($conn);
}
?>