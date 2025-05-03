<?php
include '../../koneksi.php';
session_start();

// Check if 'kd_barang' is set in the GET request
if (isset($_GET['kd_barang'])) {
    $kd_barang = $_GET['kd_barang'];
    $data = mysqli_query($koneksi, "SELECT * FROM detail_pembelian WHERE kd_barang='$kd_barang'");
}

// Check if 'no_pembelian' is set in the GET request
if (isset($_GET['no_pembelian'])) {
    $no_pembelian = $_GET['no_pembelian'];
    $data2 = mysqli_query($koneksi, "SELECT * FROM detail_pembelian WHERE no_pembelian='$no_pembelian'");
} else {
    // Handle the case when 'no_pembelian' is not set
    $no_pembelian = ''; // Or some default value or error handling
}

// Assuming $_SESSION['user_id'] contains the ID of the logged-in user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // SQL query to fetch user data
    $sql = "SELECT tipe_user FROM user WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user data is found
    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $tipe_user = $row['tipe_user'];
    } else {
        $tipe_user = "Guest"; // Default value if user_id is not set in session
    }
} else {
    $tipe_user = "Administrator"; // Default value if user data is not found
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Spica Admin</title>
    <!-- base:css -->
    <link rel="stylesheet" href="../../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/favicon.png" />
</head>

<body>
    <div class="container-scoller d-flex">
        <!--partial../../partials/_sidebar.html-->
        <?php include 'navbar.php'; ?>
        <!--partial-->
        <div class="container-fluid page-body-wrapper">
            <!--partial../../partials/_navbar.html-->
            <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <div class="navbar-brand-wrapper">
                        <a class="navbar-brand brand-logo" href="index.html"><img src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/logo.svg" alt="logo" /></a>
                        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/logo-mini.svg" alt="logo" /></a>
                    </div>
                    <h4 class="font-wight-bold mb-0 d-none d-md-block"> Welcome <?php echo htmlspecialchars($tipe_user, ENT_QUOTES, 'UTF-8'); ?></h4>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item">
                            <h4 class="mb-0 font-weight-bold d-none d-xl-block">Mar 12, 2019 - Apr 10, 2019</h4>
                        </li>
                        <li class="nav-item dropdown me-1">
                            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-calendar mx-0"></i>
                                <span class="count bg-info">2</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                                <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/faces/face4.jpg" alt="image" class="profile-pic">
                                    </div>
                                    <div class="preview-item-content flex-grow">
                                        <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                                        </h6>
                                        <p class="font-weight-light small-text text-muted mb-0">
                                            The meeting is cancelled
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/faces/face2.jpg" alt="image" class="profile-pic">
                                    </div>
                                    <div class="preview-item-content flex-grow">
                                        <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                                        </h6>
                                        <p class="font-weight-light small-text text-muted mb-0">
                                            New product launch
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/faces/face3.jpg" alt="image" class="profile-pic">
                                    </div>
                                    <div class="preview-item-content flex-grow">
                                        <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                                        </h6>
                                        <p class="font-weight-light small-text text-muted mb-0">
                                            Upcoming board meeting
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown me-2">
                            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-email-open mx-0"></i>
                                <span class="count bg-danger">1</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="mdi mdi-information mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            Just now
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-warning">
                                            <i class="mdi mdi-settings mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">Settings</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            Private message
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-info">
                                            <i class="mdi mdi-account-box mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            2 days ago
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
                <div class="navbar-menu-wrapper navbar-search-wrapper d-none d-lg-flex align-items-center">
                    <ul class="navbar-nav mr-lg-2">
                        <li class="nav-item nav-search d-none d-lg-block">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Here..." aria-label="search" aria-describedby="search">
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                                <img src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/faces/face5.jpg" alt="profile" />
                                <span class="nav-profile-name"> <?php echo htmlspecialchars($tipe_user, ENT_QUOTES, 'UTF-8'); ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item">
                                    <i class="mdi mdi-settings text-primary"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link icon-link">
                                <i class="mdi mdi-plus-circle-outline"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link icon-link">
                                <i class="mdi mdi-web"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link icon-link">
                                <i class="mdi mdi-clock-outline"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!--patrial-->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">

                        <div class="col-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">detail transaksi pemebelian faktur- <?php echo $no_pembelian; ?></h4>
                                    <br>

                                    <form method="post" action="../../proses.php?no_pembelian=<?php echo $no_pembelian; ?>&action=tambah_detail_pembelian" enctype="multipart/form-data">
                                        <?php
                                        if (isset($_GET['kd_barang'])) {
                                            $data3 = mysqli_query($koneksi, "select*from tb_barang where kd_barang='$kd_barang'");
                                            foreach ($data3 as $d) {
                                        ?>

                        <div class="container">
                            <h3>Edit Barang</h3>
                            <form action="proses.php" method="POST">
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3">Nomor Faktur Pembelian</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="no_pembelian" readonly value="<?php echo $no_pembelian; ?>">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3">Kode Barang</label>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <input type="hidden" name="kd_barang" value="<?php echo $d['kd_barang']; ?>" readonly>
                                            <input type="text" class="form-control" value="<?php echo $d['kd_barang']; ?>" readonly>
                                            <div class="input-group-append">
                                                <a href="pembelian_barang.php?no_pembelian=<?php echo $no_pembelian; ?>&action=pilih_barang" onclick="tengah(this); return false;" class="btn btn-primary">Cari Barang</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3">Nama Barang</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="nama_barang" value="<?php echo $d['nama_barang']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3">Kode Jenis Barang</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control" name="kode_jenis">
                                            <option value="ALT" <?php echo ($d['kode_jenis'] == 'ALT') ? 'selected' : ''; ?>>Alat Tulis</option>
                                            <option value="ARC" <?php echo ($d['kode_jenis'] == 'ARC') ? 'selected' : ''; ?>>Archiver</option>
                                            <option value="CET" <?php echo ($d['kode_jenis'] == 'CET') ? 'selected' : ''; ?>>Cetakan</option>
                                            <option value="HELP" <?php echo ($d['kode_jenis'] == 'HELP') ? 'selected' : ''; ?>>Helper</option>
                                            <option value="KOM" <?php echo ($d['kode_jenis'] == 'KOM') ? 'selected' : ''; ?>>Komputer</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3">Jumlah Barang</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="jumlah_barang" placeholder="Jumlah Barang">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3">Stok Saat Ini</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" value="<?php echo $d['stok']; ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3">Harga Barang</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="harga_barang" value="<?php echo $d['harga_beli']; ?>" readonly>
                                    </div>
                                </div>                             
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 offset-md-3">
                                        <button type="submit" class="btn btn-success">SUBMIT</button>
                                        <button type="reset" class="btn btn-primary">RESET</button>
                                        <a href="transaksi_pembelian.php">
                                            <button type="button" class="btn btn-danger">CANCEL</button>
                                        </a>
                                    </div>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        function tengah(meh) {
                            var x = screen.width / 2 - 1600 / 2;
                            var y = screen.height / 2 - 785 / 2;
                            window.open(meh.href, 'sharegplus', 'height=785,width=1600,left=' + x + ',top=' + y);
                        }
                    </script>

                <?php
                                            }
                                        } else {
                ?>

                <form method="post" action="proses.php?no_pembelian=<?php echo $no_pembelian; ?>&action=tambah_detail_pembelian" enctype="multipart/form-data">

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">nomor faktur pembelian</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" name="no_pembelian" readonly value="<?php echo $no_pembelian; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">kode barang</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" name="kd_barang" value="-" placeholder="kode barang" readonly>
                            <a href="pembelian_barang.php=<?php echo $no_pembelian; ?>&action=pilih_barang">cari barang</a>
                        </div>
                        <script type="text/javascript">
                            function tengah(meh) {
                                var x = screen.width / 2 - 1600 / 2;
                                var y = screen.height / 2 - 785 / 2;
                                window.open(meh.href, 'sharegplus', 'height=785,width=1600,left=' + x + ',top=' + y);
                            }
                        </script>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">nama barang</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" name="nama_barang" readonly value="-">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">kode jenis barang</label>
                        <div class="col-md-6 col-sm-6">
                            <select class="form-control" name="kode_jenis">
                                <option value="ALT">ALAT TULIS</option>
                                <option value="ARC">ARCHIVER</option>
                                <option value="CET">CETAKAN</option>
                                <option value="HELP">HELPER</option>
                                <option value="KOM">KOMPUTER</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">jumlah barang</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" class="form-control" name="jumlah_barang" placeholder="jumlah barang">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">stok saat ini</label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" class="form-control" value="-">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">harga barang</label>
                        <div class="col-md-5 col-sm-5">
                            <input type="text" class="form-control" name="harga_barang" value="-" readonly>
                        </div>
                    </div>
                    <!---GAJELAS-->
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 offset-md-3">
                            <button type="submit" class="btn btn-success">SUBMIT</button>
                            <button type="reset" class="btn btn-primary">RESET</button>
                            <a href="transaksi_pembelian.php">
                                <button type="button" class="btn btn-danger">CANCEL</button>
                            </a>
                        </div>
                    </div>

                </form>
                </div>
            </div>
        </div>

    <?php
                                        }
    ?>

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <h3> data detail transaksi pembelian</h3>
                </h4>
                <p class="card-description">
                </p>
                <div class="table-responsive">
                    <table class="table">

                        <thead>
                            <tr>
                                <th width="6%">No</th>
                                <th width="16%">No faktur pembelian</th>
                                <th width="16%">kode barang</th>
                                <th width="16%">Nama barang</th>
                                <th width="16%">kode jenis</th>
                                <th width="16%">jenis</th>
                                <th width="16%">jumlah barang</th>
                                <th width="6%">harga barang</th>
                                <th width="6%">total barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = mysqli_query($koneksi, "select*from detail_pembelian where no_pembelian = '$no_pembelian' order by no_pembelian desc");
                            $detail_pembelian = mysqli_query($koneksi, "select a.no_pembelian as no_pembelian,a.kd_barang as kd_barang,a.kode_jenis,a.jumlah_barang as jumlah_barang,a.harga_barang as harga_barang,a.total_harga as total_harga,b.nama_barang as nama_barang,c.jenis from detail_pembelian as a, tb_barang as b, tb_jenis as c where a.kd_barang = b.kd_barang and b.kode_jenis = c.kode_jenis and no_pembelian ='$no_pembelian' order by no_pembelian desc");

                            $halaman = 5;
                            $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                            $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
                            $query_mysql = mysqli_query($koneksi, "SELECT a.no_pembelian AS no_pembelian, a.kd_barang AS kd_barang, a.kode_jenis AS kode_jenis, a.jumlah_barang AS jumlah_barang, a.harga_barang AS harga_barang, a.total_harga AS total_harga, b.nama_barang AS nama_barang, c.jenis FROM detail_pembelian AS a, tb_barang AS b, tb_jenis AS c WHERE a.kd_barang = b.kd_barang AND b.kode_jenis = c.kode_jenis AND no_pembelian='$no_pembelian' ORDER BY no_pembelian DESC");                            $total = mysqli_num_rows($query_mysql);
                            $pages = ceil($total / $halaman);
                            $query = mysqli_query($koneksi, "select a.no_pembelian as no_pembelian, a.kd_barang as kd_barang, a.kode_jenis as kode_jenis, a.jumlah_barang as jumlah_barang, a.harga_barang as harga_barang, a.total_harga as total_harga,b.nama_barang as nama_barang,c.jenis from detail_pembelian as a, tb_barang as b, tb_jenis as c where a.kd_barang = b.kd_barang and b.kode_jenis = c.kode_jenis and no_pembelian='$no_pembelian'order by no_pembelian desc LIMIT $mulai,$halaman"); //OR DIE MYSQL ERROR HARUSMYA 
                            $nomor = $mulai + 1;

                            while ($d = mysqli_fetch_array($query)) {
                                $harga_barang = "RP." . number_format($d['harga_barang'], 2, ',', '.');
                                $total_harga = "RP." . number_format($d['total_harga'], 2, ',', '.');
                            ?>
                                <tr>
                                    <td><?php echo $nomor++; ?></td>
                                    <td><?php echo $d['no_pembelian']; ?></td>
                                    <td><?php echo $d['kd_barang']; ?></td>
                                    <td><?php echo $d['nama_barang']; ?></td>
                                    <td><?php echo $d['kode_jenis']; ?></td>
                                    <td><?php echo $d['jenis']; ?></td>
                                    <td><?php echo $d['jumlah_barang']; ?></td>
                                    <td><?php echo $harga_barang; ?></td>
                                    <td><?php echo $total_harga; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <div align="center">
                        <?php for ($i = 1; $i <= $pages; $i++) { ?>

                            <a href="?halaman=<?php echo $i; ?>">

                                <div class="btn-group pb-2 pb-lg-0" role="group" aria-label="basic example">
                                    <button type="button" class="btn btn-primary"><?php echo $i; ?></button>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <!--komentar-->

    <footer class="footer">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">copyright @ <a href="https://www.bootstrapdash.com/" target="_blank">BOOTSTRAPDASH.COM</a>2021</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">ONLY FANS <a href="https://www.bootstrapdash.com/" target="_blank">BOOTSTRAP DASHBORD</a>TEMPLATES</span>
                </div>
            </div>
        </div>
    </footer>
    <!--KOMENTAR-->
    </div>
    <!--KOMENTAR-->
    </div>
    <!--KOMENTAR-->
    </div>
    <!--KOMENTAR-->
    <!--KOMENTAR-->
    <script src="../../assets/template/spica/template/vendor/js/vendor.bundle.base.js"></script>
    <!--endinject-->
    <!--inject:js-->
    <script src="../../assets/template/spica/template/js/off-canvas.js"></script>
    <script src="../../assets/template/spica/template/js/hoverable-collapse.js"></script>
    <script src="../../assets/template/spica/template/js/template.js"></script>
    <!--endinject-->
    <!--plugin js for this page-->
    <!--end plugin js for this page-->
    <!--custom js for this page-->
    <script src="../../assets/template/spica/template/js/file-upload.js"></script>
    <!--custom js for this page-->
</body>

</html>