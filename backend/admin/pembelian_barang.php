<?php
include '../../koneksi.php';
session_start();

// Mendapatkan no_pembelian jika tersedia
$no_pembelian = isset($_GET['no_pembelian']) ? $_GET['no_pembelian'] : null;
$data = [];
if ($no_pembelian) {
    $data = mysqli_query($koneksi, "SELECT * FROM detail_pembelian WHERE no_pembelian = '$no_pembelian'");
}

// Memeriksa tipe user
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $koneksi->prepare("SELECT tipe_user FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tipe_user = $result->num_rows > 0 ? $result->fetch_assoc()['tipe_user'] : "Guest";
} else {
    $tipe_user = "Administrator";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Barang</title>
    <link rel="stylesheet" href="../../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/css/style.css">
    <link rel="shortcut icon" href="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/favicon.png" />
</head>
<body>
<div class="container-scroller d-flex">
        <!--partial :.../../partial/_sidebar.html-->
        <!--partial -->
        <?php include 'navbar.php';?>
        <div class="container-fluid page-body-wrapper">
            <!--partial :.../../partial/navbar.html-->
            <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <div class="navbar-brand-wrapper">
                        <a class="navbar-brand brand-logo" href="index.html"><img src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/logo.svg" alt="logo" /></a>
                        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/images/logo-mini.svg" alt="logo" /></a>
                    </div>
                    <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1">Welcome <?php echo htmlspecialchars($tipe_user, ENT_QUOTES, 'UTF-8'); ?></h4>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item">
                            <h4 class="mb-0 font-weight-bold d-none d-xl-block">Mar 12, 2019 Apr 10, 2019</h4>
                        </li>
                        <li class="nav-item dropdown me-1">
                            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href=""></a>
                                <i class="mdi mdi-calendar mx-0"></i>
                                <span class="count bg-info">2</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                                <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="../../assets/template/Spica/template/images/faces/face4.jpg" alt="image"class="profil-pic">
                                    </div>
                            <div class="preview-item-content flex-grow">
                                <h6 class=" preview-subject ellipsi font-weight-normal">David Grey
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0"> 
                                    The meeting is cancelled
                                </p>
                            </div>
                            </a>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="../../assets/template/Spica/template/images/faces/face2.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsi font-weight-normal"> 
                                Tim Cook</h6>
                                <p class="font-weight-light small-text text-muted mb-0"> 
                                New Product launch
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img src="../../assets/template/Spica/template/images/faces/face3.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsi font-weight-normal"> 
                                Johnson</h6>
                                <p class="font-weight-light small-text text-muted mb-0"> 
                                Upcoming board meeting                               
                                </p>
                            </div>
                        </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="notificationDropdown">
                            <i class="mdi mdi-email-open mx-0"></i>
                            <span class="count bg-danger">1</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notification</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview_icon bg-succes">
                                        <i class="mdi mdi-information mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class=" preview-subject ellipsi font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text text-muted"> 
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-ietm preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview_icon bg-warning">
                                        <i class="mdi mdi-settings mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class=" preview-subject ellipsi font-weight-normal">Settings</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> 
                                        Private Message
                                    </p>
                                </div>
                                </a>
                                <a class="dropdown-ietm preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="mdi mdi-account-box mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class=" preview-subject font-weight-normal">New User Registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> 
                                        2 days ago
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-Ig-none align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
            <div class="navbar-menu-wrapper navbar-search-wrapper d-none align-items-center">
                <ul class="navbar-nav mr-Ig-2">
                    <li class="navbar-item navbar-search d-none d-Ig-block">
                        <div class="input-group">
                            <input type="text" class="from-control" placeholder="Search Here..." aria-label=""></input>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown ">
                        <a class="nav-link  dropdown-toggle href="#" data-bs-toggle="dropdown" id="profileDropdon"></a>
                            <img src="../../assets/template/Spica/template/images/faces/face5.jpg" alt="image"class="profile">
                            <span class="nav-profile-name"><?php echo htmlspecialchars($tipe_user, ENT_QUOTES, 'UTF-8'); ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="mdi mdi-settings text-primary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item href="../../proses.php?action=logout">
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

    <div class="container-scroller d-flex">
        <!--partial :.../../partial/_sidebar.html-->
        <div class="container-fluid page-body-wrapper">
            <!--partial :.../../partial/navbar.html-->
            <!-- Navbar code here -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><h3>Pilih Data Barang</h3></h4>
                                    <div align="right">
                                        <a href="detail_pembelian.php?no_pembelian=<?php echo $no_pembelian;?>&action=detail_pembelian">
                                            <button class="btn btn-danger" type="button">Kembali</button>
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Barang</th>
                                                    <th>Kode Jenis</th>
                                                    <th>Nama Barang</th>
                                                    <th>Stok</th>
                                                    <th>Harga Beli</th>
                                                    <th>Harga Jual</th>
                                                    <th>Gambar Produk</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $halaman = 10;
                                                $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                                                $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
                                                $query_mysql = mysqli_query($koneksi, "SELECT * FROM tb_barang");
                                                $total = mysqli_num_rows($query_mysql);
                                                $pages = ceil($total / $halaman);
                                                $query = mysqli_query($koneksi, "SELECT * FROM tb_barang LIMIT $mulai, $halaman") or die(mysqli_error($koneksi));
                                                $nomor = $mulai + 1;
                                                while ($data = mysqli_fetch_array($query)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $nomor++; ?></td>
                                                    <td><?php echo $data['kd_barang']; ?></td>
                                                    <td><?php echo $data['kode_jenis']; ?></td>
                                                    <td><?php echo $data['nama_barang']; ?></td>
                                                    <td><?php echo $data['stok']; ?></td>
                                                    <td><?php echo "Rp" . number_format($data['harga_beli'], 2, ',', '.'); ?></td>
                                                    <td><?php echo "Rp" . number_format($data['harga_jual'], 2, ',', '.'); ?></td>
                                                    <td><img src="gambar/<?php echo $data['gambar_produk']; ?>" style="width: 120px;"></td>
                                                    <td>
                                                        <a href="detail_pembelian.php?kd_barang=<?php echo $data['kd_barang'];?>&no_pembelian=<?php echo $no_pembelian;?>&action=pilih_barang">
                                                            <button class="btn btn-primary" type="button">Pilih</button>
                                                        </a>
                                                        <a href="edit.php?kd_barang=<?php echo $data['kd_barang'];?>">
                                                            <button class="btn btn-warning" type="button">Edit</button>
                                                        </a>
                                                        <a href="proses.php?action=delete&kd_barang=<?php echo $data['kd_barang'];?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            <button class="btn btn-danger" type="button">Hapus</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div align="center">
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                            <a href="?halaman=<?php echo $i; ?>">
                                                <div class="btn-group pb-2 pb-lg-e" role="group" aria-label="Basic example">
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
                </div>
                <footer class="footer">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
                                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright <a href="https://www.bootstrapdash.com" target="_blank">bootstrapdash.com</a> 2021</span>
                                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a href="https://www.bootstrapdash.com" target="_blank">Bootstrap dashboard</a> templates</span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="../../assets/template/spica/template/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../assets/template/spica/template/js/off-canvas.js"></script>
    <script src="../../assets/template/spica/template/js/hoverable-collapse.js"></script>
    <script src="../../assets/template/spica/template/js/template.js"></script>
</body>
</html>
