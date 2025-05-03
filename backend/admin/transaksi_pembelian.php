<?php
include '../../koneksi.php';
session_start();
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
  <div class="container-scroller d-flex">
    <!-- partial:./partials/_sidebar.html -->
    <?php include '../../koneksi.php'; ?>
    <?php include 'navbar.php'; ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:./partials/_navbar.html -->
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
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Form Transaksi Pemmbelian (Barang Masuk)</h4>
                  <br>
                  <?php
                  $data = mysqli_query($koneksi, "SELECT COUNT(no_pembelian) as no_pembelian from tb_pembelian");
                  foreach ($data as $row) {
                    $count_max = $row['no_pembelian'];
                    //$pecahdata = explode('0',$kode_max);
                    //$kode_barangbaru = $pecahdata[1];
                    $no_pembelianbaru = $count_max + 1;
                    date_default_timezone_set('Asia/Jakarta');
                    $invoice = 'BUY - ' . date('Y') . date('m') . date('s') . str_pad($no_pembelianbaru, 2, '0', STR_PAD_LEFT);
                  }
                  ?>
                  <form action="../../proses.php" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 col-sm-3">Nomor Faktur Pemmbelian</label>
                      <div>
                        <input type="text" name="no_pembelian" class="form-control" value="<?php echo $invoice ?>" id="" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 col-sm-3">Tanggal Pemmbelian</label>
                      <div>
                        <input type="date" name="tanggal_pembelian" class="form-control">
                      </div>
                    </div>
                    <?php $data2 = mysqli_query($koneksi, "SELECT * FROM tb_supplier") ?>
                    <div class="form-group row">
                      <label for="" class="control-label col-md-3 col-sm-3">Supplier</label>
                      <div class="col-md-6 col-sm-6">
                        <select name="id_supplier" class="form-control" id="">
                          <option value="">--Pilih Supplier--</option>
                          <?php
                          foreach ($data2 as $d2) {
                          ?>
                            <option value="<?php echo $d2['id_supplier']; ?>"><?php echo $d2['nama_supplier']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success">Submit</button>
                      <button type="reset" class="btn btn-primary">Reset</button>
                      <a href="data_barang.php"></a>
                      <button type="button" class="btn btn-danger">Back</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Data Transaksi Pembelian (Barang Masuk)</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th width="6%">No</th>
                          <th width="16%">No Faktur Pembelian</th>
                          <th width="16%">Tanggal Pembelian</th>
                          <th width="15%">ID Supplier</th>
                          <th width="15%">Nama Supplier</th>
                          <th width="7%">Total Barang</th>
                          <th width="13%">Total Harga</th>
                          <th width="13%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $data = mysqli_query($koneksi, "SELECT * from tb_pembelian order by no_pembelian desc");
                        $data_pembelian = mysqli_query($koneksi, "SELECT a.no_pembelian as no_pembelian, a.tanggal_pembelian as tanggal_pembelian, a.id_supplier as id_supplier, a.total_barangall as totalbarangall, a.total_hargaall as total_hargaall,
                            b.nama_supplier as nama_supplier from tb_pembelian as a, tb_supplier as b where a.id_supplier = b.id_supplier order by no_pembelian desc ");

                        $halaman = 5;
                        $page = isset($_GET["halaman"]) ? (int)$_GET["halaman"] : 1;
                        $mulai = ($page > 1) ? ($page * $halaman) - $halaman : 0;
                        $query = mysqli_query($koneksi, "SELECT a.no_pembelian as no_pembelian, a.tanggal_pembelian as tanggal_pembelian,  a.id_supplier as id_supplier, a.total_barangall as totalbarangall, a.total_hargaall as total_hargaall,
                            b.nama_supplier as nama_supplier from tb_pembelian as a, tb_supplier as b where a.id_supplier = b.id_supplier order by no_pembelian desc LIMIT $mulai, $halaman") or die(mysqli_error($koneksi));

                        $nomor = $mulai + 1;
                        while ($d = mysqli_fetch_array($query)) {
                          $rupiah_harga_all = "Rp " . number_format($d['total_hargaall'], 2, ',', '.');

                        ?>
                          <tr>
                            <td><?php echo $nomor++ ?></td>
                            <td><?php echo $d['no_pembelian'] ?></td>
                            <td><?php echo $d['tanggal_pembelian'] ?></td>
                            <td><?php echo $d['id_supplier'] ?></td>
                            <td><?php echo $d['nama_supplier'] ?></td>
                            <td><?php echo $d['total_barangall'] ?></td>
                            <td><?php echo $rupiah_harga_all ?></td>
                            <td>
                              <a href="detail_pembelian.php?no_pembelian=<?php echo $d['no_pembelian'] ?>$action=detail_pembelian">Detail Transaksi</a>
                            </td>
                          </tr>
                        <?php
                        } ?>
                      </tbody>
                    </table>
                    <br>
                    <div align="center">
                      <?php for ($i = 1; $i <= $page; $i++) { ?>
                        <a href="?halaman=<?php echo $i ?>">
                          <div class="btn-group pb-2 pb-lg-0" role="group" aria-label="Basic example">
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

          <!-- content-wrapper ends -->
          <!-- partial:./partials/_footer.html -->
          <footer class="footer">
            <div class="card">
              <div class="card-body">
                <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
                  <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2021</span>
                  <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a href="https://www.bootstrapdash.com/" target="_blank"> Bootstrap dashboard </a> templates</span>
                </div>
              </div>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- base:js -->
    <script src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/chart.js/Chart.min.js"></script>
    <script src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/off-canvas.js"></script>
    <script src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/hoverable-collapse.js"></script>
    <script src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="../../assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/dashboard.js"></script>
    <!-- End custom js for this page-->
</body>

</html>