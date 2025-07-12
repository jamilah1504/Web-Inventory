<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id_karyawan']) || empty($_GET['id_karyawan'])) {
    die("ID karyawan tidak diberikan.");
}

$id_karyawan = mysqli_real_escape_string($conn, $_GET['id_karyawan']);
$sql = "SELECT * FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'";
$result = mysqli_query($conn, $sql);

if (!$result || !($row = mysqli_fetch_assoc($result))) {
    die("Data karyawan tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_karyawan = mysqli_real_escape_string($conn, $_POST['id_karyawan']);
    $nama_karyawan = mysqli_real_escape_string($conn, $_POST['nama_karyawan']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);

    if (empty($id_karyawan) || empty($nama_karyawan) || empty($jabatan)) {
        die("Semua field wajib diisi.");
    }

    $sql = "UPDATE tb_karyawan SET id_karyawan = '$id_karyawan', nama_karyawan = '$nama_karyawan', jabatan = '$jabatan' WHERE id_karyawan = '$id_karyawan'";
    if (mysqli_query($conn, $sql)) {
        header("Location: data_karyawan.php");
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
    <title>Edit Karyawan - SIMTI</title>
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
                                    <h4 class="card-title">Edit Karyawan</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:47 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>ID Karyawan</label>
                                            <input type="text" name="id_karyawan" class="form-control" value="<?php echo htmlspecialchars($row['id_karyawan']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Karyawan</label>
                                            <input type="text" name="nama_karyawan" class="form-control" value="<?php echo htmlspecialchars($row['nama_karyawan']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control" value="<?php echo htmlspecialchars($row['jabatan']); ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="data_karyawan.php" class="btn btn-secondary">Batal</a>
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