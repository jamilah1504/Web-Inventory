<?php
require_once __DIR__ . '/../../../koneksi.php';
session_start();

// Input sanitization
$kd_barang = isset($_GET['kd_barang']) ? trim($_GET['kd_barang']) : '';
$no_pembelian = isset($_GET['no_pembelian']) ? trim($_GET['no_pembelian']) : '';
$page = filter_input(INPUT_GET, 'halaman', FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]) ?? 1;
$per_page = 5;
$start = ($page - 1) * $per_page;
$pages = 1;
$data = null;

// Fetch user type
$tipe_user = 'Guest';
if (isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    try {
        $res_user = pg_query($conn, "SELECT tipe_user FROM \"user\" WHERE id = '$user_id'");
        if ($res_user && pg_num_rows($res_user) > 0) {
            $tipe_user = pg_fetch_assoc($res_user)['tipe_user'];
        }
    } catch (Exception $e) {
        error_log("Error fetching user type: " . $e->getMessage());
    }
}

// Search and pagination logic
try {
    if ($no_pembelian || $kd_barang) {
        $where = [];
        if ($no_pembelian) {
            $esc_no = pg_escape_string($conn, $no_pembelian);
            $where[] = "no_pembelian = '$esc_no'";
        }
        if ($kd_barang) {
            $esc_kd = pg_escape_string($conn, $kd_barang);
            $where[] = "kd_barang = '$esc_kd'";
        }
        $where_sql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

        // Count total rows for pagination
        $count_res = pg_query($conn, "SELECT COUNT(*) as total FROM detail_pembelian $where_sql");
        $total_rows = $count_res ? (int)(pg_fetch_assoc($count_res)['total'] ?? 0) : 0;
        $pages = ceil($total_rows / $per_page);

        // Fetch paginated data
        $query = "SELECT * FROM detail_pembelian $where_sql LIMIT $per_page OFFSET $start";
        $data = pg_query($conn, $query);
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
    <link rel="stylesheet" href="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/clean-ui.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
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
                                                <?php if ($data && pg_num_rows($data) > 0): ?>
                                                    <?php $no = $start + 1; while ($row = pg_fetch_assoc($data)): ?>
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
                <?php include_once __DIR__ . '/../../../include/footer.php'; ?>
            </div>
        </div>
    </div>

    <script src="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/js/vendor.bundle.base.js"></script>
    <script src="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/off-canvas.js"></script>
    <script src="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/misc.js"></script>
    <script src="/assets/js/custom.js"></script>
</body>
</html>

<?php
if (isset($data) && $data) {
    pg_free_result($data);
}
pg_close($conn);
?>