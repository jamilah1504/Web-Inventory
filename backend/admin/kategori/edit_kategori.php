<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id_kategori']) || empty($_GET['id_kategori'])) {
    die("ID kategori tidak diberikan.");
}

$id_kategori = mysqli_real_escape_string($conn, $_GET['id_kategori']);
$sql = "SELECT * FROM kategori_barang WHERE id_kategori = '$id_kategori'";
$result = mysqli_query($conn, $sql);

if (!$result || !($row = mysqli_fetch_assoc($result))) {
    die("Data kategori tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);
    $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

    if (empty($id_kategori) || empty($nama_kategori)) {
        die("Semua field wajib diisi.");
    }

    $sql = "UPDATE kategori_barang SET id_kategori = '$id_kategori', nama_kategori = '$nama_kategori' WHERE id_kategori = '$id_kategori'";
    if (mysqli_query($conn, $sql)) {
        header("Location: data_kategori.php");
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
    <title>Edit Kategori - SIMTI</title>
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
                                    <h4 class="card-title">Edit Kategori</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('09:47 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>ID Kategori</label>
                                            <input type="text" name="id_kategori" class="form-control" value="<?php echo htmlspecialchars($row['id_kategori']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <input type="text" name="nama_kategori" class="form-control" value="<?php echo htmlspecialchars($row['nama_kategori']); ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="data_kategori.php" class="btn btn-secondary">Batal</a>
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