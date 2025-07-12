<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['no_pembelian']) || empty($_GET['no_pembelian'])) {
    die("No pembelian tidak diberikan.");
}

$no_pembelian = mysqli_real_escape_string($conn, $_GET['no_pembelian']);
$sql = "SELECT * FROM tb_pembelian WHERE no_pembelian = '$no_pembelian'";
$result = mysqli_query($conn, $sql);

if (!$result || !($row = mysqli_fetch_assoc($result))) {
    die("Data pembelian tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_pembelian = mysqli_real_escape_string($conn, $_POST['no_pembelian']);
    $tanggal_pembelian = mysqli_real_escape_string($conn, $_POST['tanggal_pembelian']);
    $id_supplier = mysqli_real_escape_string($conn, $_POST['id_supplier']);
    $total_barangall = mysqli_real_escape_string($conn, $_POST['total_barangall']);
    $total_hargaall = mysqli_real_escape_string($conn, $_POST['total_hargaall']);

    if (empty($no_pembelian) || empty($tanggal_pembelian) || empty($id_supplier) || empty($total_barangall) || empty($total_hargaall)) {
        die("Semua field wajib diisi.");
    }

    $sql = "UPDATE tb_pembelian SET no_pembelian = '$no_pembelian', tanggal_pembelian = '$tanggal_pembelian', id_supplier = '$id_supplier', total_barangall = '$total_barangall', total_hargaall = '$total_hargaall' WHERE no_pembelian = '$no_pembelian'";
    if (mysqli_query($conn, $sql)) {
        header("Location: transaksi_pembelian.php");
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
    <title>Edit Pembelian - SIMTI</title>
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
                                    <h4 class="card-title">Edit Pembelian</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:43 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>No Pembelian</label>
                                            <input type="text" name="no_pembelian" class="form-control" value="<?php echo htmlspecialchars($row['no_pembelian']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Pembelian</label>
                                            <input type="date" name="tanggal_pembelian" class="form-control" value="<?php echo htmlspecialchars($row['tanggal_pembelian']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>ID Supplier</label>
                                            <input type="text" name="id_supplier" class="form-control" value="<?php echo htmlspecialchars($row['id_supplier']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Barang</label>
                                            <input type="number" name="total_barangall" class="form-control" value="<?php echo htmlspecialchars($row['total_barangall']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Total Harga</label>
                                            <input type="number" step="0.01" name="total_hargaall" class="form-control" value="<?php echo htmlspecialchars($row['total_hargaall']); ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="transaksi_pembelian.php" class="btn btn-secondary">Batal</a>
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