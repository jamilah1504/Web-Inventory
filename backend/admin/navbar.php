<style>
/* Sidebar Header Styles */
.sidebar-brand-wrapper {
    padding: 15px 20px; /* Balanced padding */
    transition: background 0.3s ease; /* Smooth transition for hover */
}

.sidebar-brand {
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: transform 0.2s ease, opacity 0.2s ease; /* Smooth hover effect */
}

.sidebar-brand:hover {
    transform: translateY(-2px); /* Subtle lift on hover */
    opacity: 0.9; /* Slight fade for interactivity */
}

.sidebar-brand img {
    width: 60px; /* Slightly smaller logo for balance */
    height: auto;
    margin-right: 12px; /* Consistent spacing */
    border-radius: 8px; /* Rounded corners for a modern look */
}

.sidebar-brand-text {
    font-family: 'Roboto', sans-serif; /* Modern, professional font */
    font-size: 22px; /* Slightly smaller for elegance */
    font-weight: 700; /* Bold but not overly heavy */
    color: #ffffff; /* High contrast white */
    text-transform: uppercase;
    letter-spacing: 1.5px; /* Slightly wider for clarity */
    line-height: 1.2; /* Improved readability */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .sidebar-brand-wrapper {
        padding: 10px 15px; /* Reduced padding for smaller screens */
    }

    .sidebar-brand img {
        width: 50px; /* Smaller logo on mobile */
    }

    .sidebar-brand-text {
        font-size: 18px; /* Smaller font on mobile */
        letter-spacing: 1px;
    }
}
</style>


<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <!-- Header Section -->
<div class="sidebar-brand-wrapper d-flex align-items-center justify-content-center">
    <a class="sidebar-brand brand-logo" href="/Web-Inventory/backend/supplier/index_admin.php" aria-label="SIMTI Supplier Dashboard">
        <img src="/Web-Inventory/assets/images/logo.png" alt="SIMTI Logo"/>
        <span class="sidebar-brand-text">SIMTI</span>
    </a>
</div>
  
  <ul class="nav">
    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/admin/index_admin.php">
        <i class="mdi mdi-view-quilt menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- Kelola Data -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
        <i class="mdi mdi-database menu-icon"></i>
        <span class="menu-title">Kelola Data</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic1">
        <ul class="nav flex-column sub-menu">
          <!-- Barang -->
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/admin/barang/data_barang.php">Data Barang</a>
          </li>
          <!-- Supplier -->
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/admin/supplier/data_supplier.php">Data Supplier</a>
          </li>
          <!-- Customer -->
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/admin/customer/data_customer.php">Data Customer</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Pembelian -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
        <i class="mdi mdi-cart menu-icon"></i>
        <span class="menu-title">Pembelian</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic2">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/admin/pembelian/transaksi_pembelian.php">Transaksi Pembelian</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/admin/pembelian/detail_pembelian.php">Detail Pembelian</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Penjualan -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
        <i class="mdi mdi-cash menu-icon"></i>
        <span class="menu-title">Penjualan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic3">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/admin/penjualan/input_penjualan.php">Input Penjualan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/admin/penjualan/detail_penjualan.php">Detail Penjualan</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Permintaan -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#permintaan" aria-expanded="false" aria-controls="permintaan">
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        <span class="menu-title">Permintaan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="permintaan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="/Web-Inventory/backend/admin/permintaan/daftar_permintaan.php">Daftar Permintaan</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Kategori -->
    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/admin/kategori/data_kategori.php">
        <i class="mdi mdi-tag-multiple menu-icon"></i>
        <span class="menu-title">Kategori</span>
      </a>
    </li>

    <!-- Stok Barang -->
    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/admin/barang/data_stok.php">
        <i class="mdi mdi-package-variant menu-icon"></i>
        <span class="menu-title">Stok Barang</span>
      </a>
    </li>

    <!-- Karyawan -->
    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/admin/karyawan/data_karyawan.php">
        <i class="mdi mdi-account-multiple menu-icon"></i>
        <span class="menu-title">Karyawan</span>
      </a>
    </li>

    <!-- Laporan & Log -->
    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/admin/log/log_aktivitas.php">
        <i class="mdi mdi-history menu-icon"></i>
        <span class="menu-title">Log Aktivitas</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/Web-Inventory/backend/admin/laporan/laporan_transaksi.php">
        <i class="mdi mdi-file-chart menu-icon"></i>
        <span class="menu-title">Laporan Transaksi</span>
      </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
      <a class="nav-link text-danger" href="/Web-Inventory/proses.php?action=logout">
        <i class="mdi mdi-logout menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
  </ul>
</nav>