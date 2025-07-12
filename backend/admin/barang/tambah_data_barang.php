<?php
session_start();
include '../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kd_barang = mysqli_real_escape_string($conn, $_POST['kd_barang'] ?? '');
    $kode_jenis = mysqli_real_escape_string($conn, $_POST['kode_jenis'] ?? '');
    $nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang'] ?? '');
    $harga_beli = mysqli_real_escape_string($conn, $_POST['harga_beli'] ?? 0);
    $harga_jual = mysqli_real_escape_string($conn, $_POST['harga_jual'] ?? 0);
    $stok = mysqli_real_escape_string($conn, $_POST['stok'] ?? 0);
    $gambar_produk = mysqli_real_escape_string($conn, $_POST['gambar_produk'] ?? '');

    if (empty($kd_barang) || empty($nama_barang) || empty($stok) || empty($harga_beli) || empty($harga_jual)) {
        die("Semua field wajib diisi.");
    }

    $sql = "INSERT INTO tb_barang (kd_barang, kode_jenis, nama_barang, stok, harga_beli, harga_jual, gambar_produk) VALUES ('$kd_barang', '$kode_jenis', '$nama_barang', '$stok', '$harga_beli', '$harga_jual', '$gambar_produk')";
    if (mysqli_query($conn, $sql)) {
        header("Location: data_barang.php");
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
    <title>Tambah Barang - SIMTI</title>
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/Web-Inventory/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/css/style.css">
</head>
<body>
    <div class="container-scroller d-flex">
        <?php include '../../navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Tambah Barang</h4>
                                    <p class="card-description">Last updated: <?php echo date('H:i A, F d, Y', strtotime('08:56 PM WIB')); ?></p>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label>Kode Barang</label>
                                            <input type="text" name="kd_barang" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kode Jenis</label>
                                            <input type="text" name="kode_jenis" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Barang</label>
                                            <input type="text" name="nama_barang" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Beli</label>
                    <input type="number" step="0.01" name="harga_beli" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Jual</label>
                    <input type="number" step="0.01" name="harga_jual" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Stok</label>
                                            <input type="number" name="stok" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Gambar Produk</label>
                                            <input type="text" name="gambar_produk" class="form-control" placeholder="URL atau path gambar">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="data_barang.php" class="btn btn-secondary">Batal</a>
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