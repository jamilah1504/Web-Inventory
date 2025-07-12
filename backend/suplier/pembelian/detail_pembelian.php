<?php
require '../../../koneksi.php';
session_start();

// Input sanitization
$kd_barang = filter_input(INPUT_GET, 'kd_barang', FILTER_SANITIZE_STRING) ?? '';
$no_pembelian = filter_input(INPUT_GET, 'no_pembelian', FILTER_SANITIZE_STRING) ?? '';
$page = filter_input(INPUT_GET, 'halaman', FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]) ?? 1;
$per_page = 5;
$start = ($page - 1) * $per_page;
$pages = 1;
$data = null;

// Fetch user type
$tipe_user = 'Guest';
if (isset($_SESSION['user_id'])) {
    $user_id = filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT);
    try {
        $stmt = $conn->prepare("SELECT tipe_user FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $tipe_user = $result->fetch_assoc()['tipe_user'];
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log("Error fetching user type: " . $e->getMessage());
    }
}

// Search and pagination logic
try {
    if ($no_pembelian || $kd_barang) {
        $query = "SELECT * FROM detail_pembelian WHERE 1=1";
        $count_query = "SELECT COUNT(*) as total FROM detail_pembelian WHERE 1=1";
        $params = [];
        $types = '';

        if ($no_pembelian) {
            $query .= " AND no_pembelian = ?";
            $count_query .= " AND no_pembelian = ?";
            $params[] = $no_pembelian;
            $types .= 's';
        }
        if ($kd_barang) {
            $query .= " AND kd_barang = ?";
            $count_query .= " AND kd_barang = ?";
            $params[] = $kd_barang;
            $types .= 's';
        }

        // Count total rows for pagination
        $stmt_total = $conn->prepare($count_query);
        if ($params) {
            $stmt_total->bind_param($types, ...$params);
        }
        $stmt_total->execute();
        $total_rows = $stmt_total->get_result()->fetch_assoc()['total'] ?? 0;
        $pages = ceil($total_rows / $per_page);
        $stmt_total->close();

        // Fetch paginated data
        $query .= " LIMIT ?, ?";
        $params[] = $start;
        $params[] = $per_page;
        $types .= 'ii';

        $stmt = $conn->prepare($query);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $data = $stmt->get_result();
        $stmt->close();
    }
} catch (Exception $e) {
    error_log("Error executing query: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Pembelian - SIMTI</title>
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/css/style.css">
    <link rel="stylesheet" href="/Web-Inventory/assets/css/custom.css">
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
                                    <h4 class="card-title">Detail Pembelian</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y'); ?></p>
                                    <form method="GET" action="">
                                        <div class="form-group">
                                            <label for="kd_barang">Kode Barang</label>
                                            <input type="text" class="form-control" id="kd_barang" name="kd_barang" value="<?php echo htmlspecialchars($kd_barang); ?>" placeholder="Masukkan Kode Barang">
                                        </div>
                                        <div class="form-group">
                                            <label for="no_pembelian">No Pembelian</label>
                                            <input type="text" class="form-control" id="no_pembelian" name="no_pembelian" value="<?php echo htmlspecialchars($no_pembelian); ?>" placeholder="Masukkan No Pembelian">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                        <a href="detail_pembelian.php" class="btn btn-secondary">Reset</a>
                                    </form>

                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Barang</th>
                                                    <th>Nama Barang</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Total Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($data && $data->num_rows > 0): ?>
                                                    <?php $no = $start + 1; while ($row = $data->fetch_assoc()): ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo htmlspecialchars($row['kd_barang']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['harga_satuan']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['total_harga']); ?></td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php else: ?>
                                                    <tr><td colspan="6" class="text-center">Tidak ada data ditemukan.</td></tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php if (($no_pembelian || $kd_barang) && $pages > 1): ?>
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination">
                                                <?php for ($i = 1; $i <= $pages; $i++): ?>
                                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                        <a class="page-link" href="?<?php echo http_build_query(['no_pembelian' => $no_pembelian, 'kd_barang' => $kd_barang, 'halaman' => $i]); ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>
                                        </nav>
                                    <?php endif; ?>
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
    <script src="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/misc.js"></script>
    <script src="/Web-Inventory/assets/js/custom.js"></script>
</body>
</html>

<?php
// Clean up resources
if (isset($data)) {
    $data->free();
}
$conn->close();
?>