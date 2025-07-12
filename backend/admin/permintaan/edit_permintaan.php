<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id_keluar']) || empty($_GET['id_keluar'])) {
    die("ID keluar tidak diberikan.");
}

$id_keluar = mysqli_real_escape_string($conn, $_GET['id_keluar']);
$sql = "SELECT * FROM stok_keluar WHERE id_keluar = '$id_keluar'";
$result = mysqli_query($conn, $sql);

if (!$result || !($row = mysqli_fetch_assoc($result))) {
    die("Data permintaan tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kd_barang = mysqli_real_escape_string($conn, $_POST['kd_barang']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan']);

    if (empty($kd_barang) || empty($jumlah) || empty($tanggal) || empty($alasan)) {
        die("Semua field wajib diisi.");
    }

    $sql = "UPDATE stok_keluar SET kd_barang = '$kd_barang', jumlah = '$jumlah', tanggal = '$tanggal', alasan = '$alasan' WHERE id_keluar = '$id_keluar'";
    if (mysqli_query($conn, $sql)) {
        header("Location: daftar_permintaan.php");
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
    <title>Edit Permintaan - SIMTI</title>
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
                                    <h4 class="card-title">Edit Permintaan</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:47 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>Kode Barang</label>
                                            <input type="text" name="kd_barang" class="form-control" value="<?php echo htmlspecialchars($row['kd_barang']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah</label>
                                            <input type="number" name="jumlah" class="form-control" value="<?php echo htmlspecialchars($row['jumlah']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($row['tanggal']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Alasan</label>
                                            <input type="text" name="alasan" class="form-control" value="<?php echo htmlspecialchars($row['alasan']); ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="daftar_permintaan.php" class="btn btn-secondary">Batal</a>
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