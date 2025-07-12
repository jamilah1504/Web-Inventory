<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_karyawan = mysqli_real_escape_string($conn, $_POST['id_karyawan']);
    $nama_karyawan = mysqli_real_escape_string($conn, $_POST['nama_karyawan']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);

    if (empty($id_karyawan) || empty($nama_karyawan) || empty($jabatan)) {
        die("Semua field wajib diisi.");
    }

    $sql = "INSERT INTO tb_karyawan (id_karyawan, nama_karyawan, jabatan) VALUES ('$id_karyawan', '$nama_karyawan', '$jabatan')";
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
    <title>Tambah Karyawan - SIMTI</title>
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
                                    <h4 class="card-title">Tambah Karyawan</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:47 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>ID Karyawan</label>
                                            <input type="text" name="id_karyawan" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Karyawan</label>
                                            <input type="text" name="nama_karyawan" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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