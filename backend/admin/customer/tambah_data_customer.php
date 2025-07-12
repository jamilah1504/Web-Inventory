<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_customer = mysqli_real_escape_string($conn, $_POST['id_customer']);
    $nama_customer = mysqli_real_escape_string($conn, $_POST['nama_customer']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat_customer = mysqli_real_escape_string($conn, $_POST['alamat_customer']);
    $telepon_customer = mysqli_real_escape_string($conn, $_POST['telepon_customer']);
    $email_customer = mysqli_real_escape_string($conn, $_POST['email_customer']);
    $pass_customer = mysqli_real_escape_string($conn, $_POST['pass_customer']);

    if (empty($id_customer) || empty($nama_customer) || empty($jenis_kelamin) || empty($alamat_customer) || empty($telepon_customer) || empty($email_customer) || empty($pass_customer)) {
        die("Semua field wajib diisi.");
    }

    $sql = "INSERT INTO tb_customer (id_customer, nama_customer, jenis_kelamin, alamat_customer, telepon_customer, email_customer, pass_customer) VALUES ('$id_customer', '$nama_customer', '$jenis_kelamin', '$alamat_customer', '$telepon_customer', '$email_customer', '$pass_customer')";
    if (mysqli_query($conn, $sql)) {
        header("Location: data_customer.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Customer - SIMTI</title>
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/css/style.css">
</head>
<body>
    <div class="container-scroller d-flex">
        <?php include '../navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Tambah Customer</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:43 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>ID Customer</label>
                                            <input type="text" name="id_customer" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Customer</label>
                                            <input type="text" name="nama_customer" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-control" required>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat Customer</label>
                                            <input type="text" name="alamat_customer" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Telepon Customer</label>
                                            <input type="text" name="telepon_customer" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email Customer</label>
                                            <input type="email" name="email_customer" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password Customer</label>
                                            <input type="password" name="pass_customer" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="data_customer.php" class="btn btn-secondary">Batal</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/js/vendor.bundle.base.js"></script>
    <script src="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/off-canvas.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>