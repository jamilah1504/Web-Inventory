<?php
include "koneksi.php";

$action = $_GET['action'];
if($action == "login"){
    session_start();
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query untuk mencari pengguna pada tabel user
    $query1 = "SELECT * FROM user WHERE username = '$username' AND password='$password'";
    $result1 = mysqli_query($koneksi, $query1);

    // Query untuk mencari pengguna pada tabel tb_customer
    $query2 = "SELECT * FROM tb_customer WHERE email_customer = '$username' AND pass_customer='$password'";
    $result2 = mysqli_query($koneksi, $query2);

    // Query untuk mencari pengguna pada tabel tb_supplier - DIUBAH
    $query3 = "SELECT * FROM tb_supplier WHERE email_supplier = '$username' AND pass_supplier='$password'";
    $result3 = mysqli_query($koneksi, $query3);

    $cek = $cek2 = $cek3 = null;

    if ($result1 && mysqli_num_rows($result1) > 0) {
        $cek = $result1->fetch_assoc();
    } elseif ($result2 && mysqli_num_rows($result2) > 0) {
        $cek2 = $result2->fetch_assoc();
    } elseif ($result3 && mysqli_num_rows($result3) > 0) {
        $cek3 = $result3->fetch_assoc();
    } else {
        echo "<script> alert('Login gagal, username dan password tidak sesuai'); window.location='login-2.php'</script>";
        exit();
    }

    if(!empty($cek)){
        $_SESSION['username'] = $username;
        $_SESSION['tipe_user'] = "Administrator";
        $tipe_user = $_SESSION['tipe_user'];
        echo "<script> alert('Login berhasil selamat datang $tipe_user'); window.location='backend/admin/index_admin.php'</script>";
    }
    else if(!empty($cek2)){
        $_SESSION['username'] = $username;
        $_SESSION['tipe_user'] = "Customer";
        $tipe_user = $_SESSION['tipe_user'];
        echo "<script> alert('Login berhasil selamat datang $tipe_user'); window.location='backend/admin/index_customer.php'</script>";
    }
    else if(!empty($cek3)){
        $_SESSION['username'] = $username;
        $_SESSION['tipe_user'] = "Supplier";
        $tipe_user = $_SESSION['tipe_user'];
        echo "<script> alert('Login berhasil selamat datang $tipe_user'); window.location='backend/admin/index_suplier.php'</script>";
    }
}

else if($action == "tambah_pembelian"){
    $no_pembelian = $_POST['no_pembelian'];
    $tanggal_pembelian = $_POST['tanggal_pembelian'];
    $id_supplier = $_POST['id_supplier'];
    $total_barangall = null;
    $total_hargaall = null;
    try{
        $query = "INSERT into tb_pembelian values ('$no_pembelian','$tanggal_pembelian','$id_supplier','$total_barangall','$total_hargaall')";
        $result = mysqli_query($koneksi,$query);
        echo "<script>alert('Data transaksi pembelian berhasil ditambah.');window.location='backend/admin/transaksi_pembelian.php';</script>";
    } catch (mysqli_sql_exception $e){
        var_dump($e);
        echo "<script>alert('Data transaksi pembelian gagal.');window.location='backend/admin/transaksi_pembelian.php';</script>";
    }
}
else if($action == "tambah_detail_pembelian"){
    $no_pembelian = $_POST['no_pembelian'];
    $kd_barang = $_POST['kd_barang'];
    $kode_jenis = $_POST['kode_jenis'];
    $jumlah_barang = $_POST['jumlah_barang'];
    $harga_barang = $_POST['harga_barang'];

        $stok =0;
        $total_barang =0;
        $total_harga =0;
        try{
            $stok_barang = mysqli_query($koneksi,"SELECT stok from tb_barang where kd_barang = '$kd_barang ");
            while($d = mysqli_fetch_array($stok_barang)){
                $stok = $d['stok'];
            }
            $stok_terkini = $jumlah_barang +$stok;
            $total_hargasatuan = $jumlah_barang*$harga_barang;

            $query1 = "INSERT into detail_pembelian values ('$no_pembelian','$kd_barang','$kode_jenis','$jumlah_barang','$harga_barang','$total_hargasatuan''')";
            $query2 = "UPDATE tb_barang set stok='$stok_terkini' where kd_barang='$kd_barang'";
            $result1= mysqli_query($koneksi,$query1);
            $result2= mysqli_query($koneksi,$query2);

            $total_barangall = mysqli_query($koneksi,"SELECT sum(jumlah_barang) as jumlah_barangall from detail_pembelian where no_pembelian='$no_pembelian'");
            while($d = mysqli_fetch_array($total_barangall)){
                $total_harga = $d['jumlah_hargaall'];
            }

            $query3 = "UPDATE tb_pembelian set total_barangall='$total_barang', total_hargaall='$total_harga' where no_pemebelian='$no_pembeelian'";
            $result3= mysqli_query($koneksi,$query3);
            echo "<script>alert('Data transaksi pembelian berhasil.');window.location='backend/admin/transaksi_pembelian.php';</script>";
        } catch(mysqli_sql_exception $e){
            var_dump($e);
            echo "<script>alert('Data transaksi pembelian gagal.');window.location='backend/admin/transaksi_pembelian.php';</script>";
        }
}
else if($action == "logout"){
    unset($_SESSION['username']);
    session_unset();
    session_destroy();
    echo "<script>alert('Anda berhasil logout. Terima kasih');window.location='index.php';</script>";
}
?>