<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM tb_barang";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Barang - SIMTI</title>
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
                                    <h4 class="card-title">Data Barang</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('08:15 PM WIB')); ?></p>
                                    <a href="tambah_data_barang.php" class="btn btn-primary mb-3">Tambah Barang</a>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nama</th>
                                                    <th>Harga Beli</th>
                                                    <th>Harga Jual</th>
                                                    <th>Stok</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $hasData = false;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $hasData = true;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($row['kd_barang'] ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['nama_barang'] ?? 'N/A'); ?></td>
                                                        <td><?php echo isset($row['harga_beli']) ? number_format($row['harga_beli'], 2) : '0.00'; ?></td>
                                                        <td><?php echo isset($row['harga_jual']) ? number_format($row['harga_jual'], 2) : '0.00'; ?></td>
                                                        <td><?php echo isset($row['stok']) ? $row['stok'] : '0'; ?></td>
                                                        <td>
                                                            <a href="edit_barang.php?kd_barang=<?php echo htmlspecialchars($row['kd_barang'] ?? ''); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                            <a href="hapus_barang.php?kd_barang=<?php echo htmlspecialchars($row['kd_barang'] ?? ''); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                if (!$hasData) {
                                                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data barang.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
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