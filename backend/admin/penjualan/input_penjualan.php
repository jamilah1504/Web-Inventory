<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_penjualan = mysqli_real_escape_string($conn, $_POST['no_penjualan']);
    $tanggal_penjualan = mysqli_real_escape_string($conn, $_POST['tanggal_penjualan']);
    $id_customer = mysqli_real_escape_string($conn, $_POST['id_customer']);
    $total_barangall = mysqli_real_escape_string($conn, $_POST['total_barangall']);
    $total_hargaall = mysqli_real_escape_string($conn, $_POST['total_hargaall']);

    if (empty($no_penjualan) || empty($tanggal_penjualan) || empty($id_customer) || empty($total_barangall) || empty($total_hargaall)) {
        die("Semua field wajib diisi.");
    }

    $sql = "INSERT INTO tb_penjualan (no_penjualan, tanggal_penjualan, id_customer, total_barangall, total_hargaall) VALUES ('$no_penjualan', '$tanggal_penjualan', '$id_customer', '$total_barangall', '$total_hargaall')";
    if (mysqli_query($conn, $sql)) {
        header("Location: detail_penjualan.php");
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
    <title>Input Penjualan - SIMTI</title>
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
                                    <h4 class="card-title">Tambah Penjualan</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:43 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>No Penjualan</label>
                                            <input type="text" name="no_penjualan" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Penjualan</label>
                                            <input type="date" name="tanggal_penjualan" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>ID Customer</label>
                                            <input type="text" name="id_customer" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Barang</label>
                                            <input type="number" name="total_barangall" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Harga</label>
                                            <input type="number" step="0.01" name="total_hargaall" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="detail_penjualan.php" class="btn btn-secondary">Batal</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include '../../../include/footer.php'; ?>
            </div>
        </div>
    </div>
    <script src="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/js/vendor.bundle.base.js"></script>
    <script src="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/off-canvas.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>