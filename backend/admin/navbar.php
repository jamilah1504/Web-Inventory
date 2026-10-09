<?php
$current_page = basename($_SERVER['PHP_SELF']);
$admin_user = $_SESSION['username'] ?? 'Administrator';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  #sidebar {
    background: #0f172a !important;
    width: 260px !important;
    min-height: 100vh;
    border-right: 1px solid rgba(255, 255, 255, 0.06);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .sidebar-brand-wrapper {
    padding: 24px 20px 20px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  }

  .brand-logo-container {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }

  .brand-logo-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
  }

  .brand-logo-text {
    font-weight: 800;
    font-size: 1.25rem;
    color: #ffffff;
    letter-spacing: -0.02em;
    line-height: 1.1;
  }

  .brand-logo-sub {
    font-size: 0.725rem;
    color: #94a3b8;
    font-weight: 500;
  }

  .nav-section-title {
    font-size: 0.675rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 18px 20px 8px 20px;
    margin: 0;
  }

  .sidebar-nav {
    list-style: none;
    padding: 12px 10px;
    margin: 0;
    flex: 1;
  }

  .sidebar-nav .nav-item {
    margin-bottom: 3px;
  }

  .sidebar-nav .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.18s ease;
  }

  .sidebar-nav .nav-link i {
    width: 20px;
    text-align: center;
    font-size: 1rem;
    color: #64748b;
    transition: color 0.18s ease;
  }

  .sidebar-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #ffffff;
    transform: translateX(3px);
  }

  .sidebar-nav .nav-link:hover i {
    color: #818cf8;
  }

  .sidebar-nav .nav-item.active .nav-link {
    background: #4f46e5;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
  }

  .sidebar-nav .nav-item.active .nav-link i {
    color: #ffffff;
  }

  .sidebar-user-footer {
    padding: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    background: rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .user-info-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .user-avatar-pill {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
    color: white;
    font-weight: 700;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .user-name-text {
    font-size: 0.85rem;
    font-weight: 700;
    color: #f1f5f9;
    line-height: 1.2;
  }

  .user-role-badge {
    font-size: 0.7rem;
    color: #10b981;
    font-weight: 600;
  }

  .logout-btn-link {
    color: #ef4444;
    font-size: 1rem;
    padding: 8px;
    border-radius: 8px;
    transition: background 0.2s ease;
    text-decoration: none;
  }

  .logout-btn-link:hover {
    background: rgba(239, 68, 68, 0.15);
  }
</style>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div>
    <!-- Brand Header -->
    <div class="sidebar-brand-wrapper">
      <a class="brand-logo-container" href="/backend/admin/index_admin.php">
        <div class="brand-logo-icon">
          <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <div>
          <div class="brand-logo-text">SIMTI</div>
          <div class="brand-logo-sub">Inventory Cloud</div>
        </div>
      </a>
    </div>

    <!-- Navigation List -->
    <ul class="sidebar-nav">
      <li class="nav-section-title">Menu Utama</li>
      <li class="nav-item <?= ($current_page == 'index_admin.php') ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/index_admin.php">
          <i class="fa-solid fa-chart-pie"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-section-title">Master Data</li>
      <li class="nav-item <?= in_array($current_page, ['data_barang.php', 'tambah_data_barang.php', 'edit_barang.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/barang/data_barang.php">
          <i class="fa-solid fa-box"></i>
          <span>Data Barang</span>
        </a>
      </li>
      <li class="nav-item <?= ($current_page == 'data_stok.php') ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/barang/data_stok.php">
          <i class="fa-solid fa-layer-group"></i>
          <span>Stok Barang</span>
        </a>
      </li>
      <li class="nav-item <?= in_array($current_page, ['data_kategori.php', 'tambah_data_kategori.php', 'edit_kategori.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/kategori/data_kategori.php">
          <i class="fa-solid fa-tags"></i>
          <span>Kategori</span>
        </a>
      </li>
      <li class="nav-item <?= in_array($current_page, ['data_supplier.php', 'tambah_data_supplier.php', 'edit_supplier.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/supplier/data_supplier.php">
          <i class="fa-solid fa-truck-field"></i>
          <span>Supplier</span>
        </a>
      </li>
      <li class="nav-item <?= in_array($current_page, ['data_customer.php', 'tambah_data_customer.php', 'edit_customer.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/customer/data_customer.php">
          <i class="fa-solid fa-users"></i>
          <span>Customer</span>
        </a>
      </li>
      <li class="nav-item <?= in_array($current_page, ['data_karyawan.php', 'tambah_data_karyawan.php', 'edit_karyawan.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/karyawan/data_karyawan.php">
          <i class="fa-solid fa-id-badge"></i>
          <span>Karyawan</span>
        </a>
      </li>

      <li class="nav-section-title">Transaksi</li>
      <li class="nav-item <?= in_array($current_page, ['transaksi_pembelian.php', 'detail_pembelian.php', 'pembelian_barang.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/pembelian/transaksi_pembelian.php">
          <i class="fa-solid fa-cart-shopping"></i>
          <span>Pembelian Stok</span>
        </a>
      </li>
      <li class="nav-item <?= in_array($current_page, ['input_penjualan.php', 'detail_penjualan.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/penjualan/detail_penjualan.php">
          <i class="fa-solid fa-receipt"></i>
          <span>Penjualan</span>
        </a>
      </li>
      <li class="nav-item <?= in_array($current_page, ['daftar_permintaan.php', 'tambah_permintaan.php', 'edit_permintaan.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/permintaan/daftar_permintaan.php">
          <i class="fa-solid fa-clipboard-list"></i>
          <span>Permintaan</span>
        </a>
      </li>

      <li class="nav-section-title">Aktivitas & Laporan</li>
      <li class="nav-item <?= ($current_page == 'laporan_transaksi.php') ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/laporan/laporan_transaksi.php">
          <i class="fa-solid fa-chart-line"></i>
          <span>Laporan Transaksi</span>
        </a>
      </li>
      <li class="nav-item <?= ($current_page == 'log_aktivitas.php') ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/admin/log/log_aktivitas.php">
          <i class="fa-solid fa-clock-rotate-left"></i>
          <span>Log Aktivitas</span>
        </a>
      </li>
    </ul>
  </div>

  <!-- User Info Footer -->
  <div class="sidebar-user-footer">
    <div class="user-info-wrap">
      <div class="user-avatar-pill">
        <?= strtoupper(substr($admin_user, 0, 1)) ?>
      </div>
      <div>
        <div class="user-name-text"><?= htmlspecialchars($admin_user) ?></div>
        <div class="user-role-badge">● Administrator</div>
      </div>
    </div>
    <a href="/proses.php?action=logout" class="logout-btn-link" title="Keluar / Logout" onclick="return confirm('Apakah Anda yakin ingin logout?');">
      <i class="fa-solid fa-arrow-right-from-bracket"></i>
    </a>
  </div>
</nav>