<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM stok_keluar";
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
    <title>Daftar Permintaan - SIMTI</title>
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
                                    <h4 class="card-title">Daftar Permintaan</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('10:10 PM WIB')); ?></p>
                                    <a href="tambah_permintaan.php" class="btn btn-primary mb-3">Tambah Permintaan</a>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID Keluar</th>
                                                    <th>Kode Barang</th>
                                                    <th>Jumlah</th>
                                                    <th>Tanggal</th>
                                                    <th>Alasan</th>
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
                                                        <td><?php echo htmlspecialchars($row['id_keluar'] ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['kd_barang'] ?? 'N/A'); ?></td>
                                                        <td><?php echo isset($row['jumlah']) ? $row['jumlah'] : '0'; ?></td>
                                                        <td><?php echo htmlspecialchars($row['tanggal'] ?? 'N/A'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['alasan'] ?? 'N/A'); ?></td>
                                                        <td>
                                                            <a href="edit_permintaan.php?id_keluar=<?php echo htmlspecialchars($row['id_keluar'] ?? ''); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                            <a href="hapus_permintaan.php?id_keluar=<?php echo htmlspecialchars($row['id_keluar'] ?? ''); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                if (!$hasData) {
                                                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data permintaan.</td></tr>";
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
                <?php include '../../../include/footer.php'; ?>
            </div>
        </div>
    </div>
    <script src="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/js/vendor.bundle.base.js"></script>
    <script src="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/off-canvas.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>