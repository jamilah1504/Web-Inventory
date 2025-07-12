<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_supplier = mysqli_real_escape_string($conn, $_POST['id_supplier']);
    $nama_supplier = mysqli_real_escape_string($conn, $_POST['nama_supplier']);
    $alamat_supplier = mysqli_real_escape_string($conn, $_POST['alamat_supplier']);
    $telepon_supplier = mysqli_real_escape_string($conn, $_POST['telepon_supplier']);
    $email_supplier = mysqli_real_escape_string($conn, $_POST['email_supplier']);
    $pass_supplier = mysqli_real_escape_string($conn, $_POST['pass_supplier']);

    if (empty($id_supplier) || empty($nama_supplier) || empty($alamat_supplier) || empty($telepon_supplier) || empty($email_supplier) || empty($pass_supplier)) {
        die("Semua field wajib diisi.");
    }

    $sql = "INSERT INTO tb_supplier (id_supplier, nama_supplier, alamat_supplier, telepon_supplier, email_supplier, pass_supplier) VALUES ('$id_supplier', '$nama_supplier', '$alamat_supplier', '$telepon_supplier', '$email_supplier', '$pass_supplier')";
    if (mysqli_query($conn, $sql)) {
        header("Location: data_supplier.php");
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
    <title>Tambah Supplier - SIMTI</title>
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
                                    <h4 class="card-title">Tambah Supplier</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:43 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>ID Supplier</label>
                                            <input type="text" name="id_supplier" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Supplier</label>
                                            <input type="text" name="nama_supplier" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat Supplier</label>
                                            <input type="text" name="alamat_supplier" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Telepon Supplier</label>
                                            <input type="text" name="telepon_supplier" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email Supplier</label>
                                            <input type="email" name="email_supplier" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password Supplier</label>
                                            <input type="password" name="pass_supplier" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="data_supplier.php" class="btn btn-secondary">Batal</a>
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