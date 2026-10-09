<?php
include "koneksi.php";
session_start();

$action = $_GET['action'] ?? '';

if ($action == "login") {
    $username = pg_escape_string($conn, $_POST['username'] ?? '');
    $password = pg_escape_string($conn, $_POST['password'] ?? '');

    // Cek user administrator
    $query1 = "SELECT * FROM \"user\" WHERE username = '$username' AND password = '$password'";
    $result1 = pg_query($conn, $query1);

    // Cek customer
    $query2 = "SELECT * FROM tb_customer WHERE email_customer = '$username' AND pass_customer = '$password'";
    $result2 = pg_query($conn, $query2);

    // Cek supplier
    $query3 = "SELECT * FROM tb_supplier WHERE email_supplier = '$username' AND pass_supplier = '$password'";
    $result3 = pg_query($conn, $query3);

    if ($result1 && pg_num_rows($result1) > 0) {
        $user = pg_fetch_assoc($result1);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['tipe_user'] = "Administrator";
        echo "<script>alert('Login berhasil. Selamat datang Administrator'); window.location='backend/admin/index_admin.php';</script>";
    } elseif ($result2 && pg_num_rows($result2) > 0) {
        $user = pg_fetch_assoc($result2);
        $_SESSION['user_id'] = $user['id_customer'];
        $_SESSION['username'] = $user['email_customer'];
        $_SESSION['tipe_user'] = "Customer";
        echo "<script>alert('Login berhasil. Selamat datang Customer'); window.location='backend/customer/index_customer.php';</script>";
    } elseif ($result3 && pg_num_rows($result3) > 0) {
        $user = pg_fetch_assoc($result3);
        $_SESSION['user_id'] = $user['id_supplier'];
        $_SESSION['username'] = $user['email_supplier'];
        $_SESSION['tipe_user'] = "Supplier";
        echo "<script>alert('Login berhasil. Selamat datang Supplier'); window.location='backend/suplier/index_suplier.php';</script>";
    } else {
        echo "<script>alert('Login gagal, username atau password salah'); window.location='login.php';</script>";
    }
}
elseif ($action == "register") {
    $username = pg_escape_string($conn, $_POST['username'] ?? '');
    $email = pg_escape_string($conn, $_POST['email'] ?? '');
    $password = pg_escape_string($conn, $_POST['password'] ?? '');
    $id_cust = "CST-" . time();

    $check = pg_query($conn, "SELECT * FROM tb_customer WHERE email_customer = '$email'");
    if ($check && pg_num_rows($check) > 0) {
        echo "<script>alert('Email sudah terdaftar!'); window.location='register.php';</script>";
    } else {
        $ins = pg_query($conn, "INSERT INTO tb_customer (id_customer, nama_customer, email_customer, pass_customer) VALUES ('$id_cust', '$username', '$email', '$password')");
        if ($ins) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal.'); window.location='register.php';</script>";
        }
    }
}
elseif ($action == "logout") {
    session_unset();
    session_destroy();
    echo "<script>alert('Anda berhasil logout. Terima kasih'); window.location='index.php';</script>";
}
?>
