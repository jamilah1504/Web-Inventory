<?php
session_start();
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

$sql = "SELECT * FROM tb_pembelian";
$result = pg_query($conn, $sql);

if (!$result) {
    die("Query failed: " . pg_last_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Transaksi Pembelian - SIMTI</title>
    <link rel="stylesheet" href="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/clean-ui.css">
</head>
<body>
    <div class="container-scroller d-flex">
        <?php include_once __DIR__ . '/../navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Transaksi Pembelian</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:43 PM WIB')); ?></p>
                                    <a href="pembelian_barang.php" class="btn btn-primary mb-3">Tambah Pembelian</a>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No Pembelian</th>
                                                    <th>Tanggal Pembelian</th>
                                                    <th>ID Supplier</th>
                                                    <th>Total Barang</th>
                                                    <th>Total Harga</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (pg_num_rows($result) > 0) {
                                                    while ($row = pg_fetch_assoc($result)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($row['no_pembelian']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['tanggal_pembelian']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['id_supplier']); ?></td>
                                                            <td><?php echo $row['total_barangall']; ?></td>
                                                            <td><?php echo number_format($row['total_hargaall'], 2); ?></td>
                                                            <td>
                                                                <a href="edit_pembelian.php?no_pembelian=<?php echo htmlspecialchars($row['no_pembelian']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                                <a href="hapus_pembelian.php?no_pembelian=<?php echo htmlspecialchars($row['no_pembelian']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6' class='text-center'>Tidak ada transaksi pembelian.</td></tr>";
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
    <script src="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/off-canvas.js"></script>
</body>
</html>
<?php pg_close($conn); ?>