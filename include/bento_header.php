<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$active_user = $_SESSION['username'] ?? 'Admin';
$user_role = $_SESSION['tipe_user'] ?? 'Administrator';

function is_bento_active($names, $cur_page, $cur_dir) {
    if (is_array($names)) {
        return in_array($cur_page, $names) || in_array($cur_dir, $names);
    }
    return ($cur_page === $names || $cur_dir === $names);
}
?>
<!-- TOP CAPSULE NAVIGATION (Image 1 Style) -->
<header class="bento-nav-wrapper">
  <!-- Brand -->
  <a href="/backend/admin/index_admin.php" class="bento-brand">
    <img src="/assets/images/logo.png" alt="SIMTI Logo" style="width: 38px; height: 38px; border-radius: 12px; object-fit: contain; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);">
    <div>
      <div class="bento-brand-name">SIMTI</div>
    </div>
  </a>

  <!-- Floating Segmented Pill Capsule -->
  <nav class="bento-pill-capsule">
    <a href="/backend/admin/index_admin.php" 
       class="bento-pill-tab <?= is_bento_active('index_admin.php', $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-chart-pie"></i>
      <span>Dashboard</span>
    </a>

    <a href="/backend/admin/barang/data_barang.php" 
       class="bento-pill-tab <?= is_bento_active(['data_barang.php', 'tambah_data_barang.php', 'edit_barang.php'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-box"></i>
      <span>Barang</span>
    </a>

    <a href="/backend/admin/barang/data_stok.php" 
       class="bento-pill-tab <?= is_bento_active(['data_stok.php', 'tambah_stok.php', 'edit_stok.php'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-layer-group"></i>
      <span>Stok</span>
    </a>

    <a href="/backend/admin/supplier/data_supplier.php" 
       class="bento-pill-tab <?= is_bento_active(['data_supplier.php', 'tambah_data_supplier.php', 'edit_supplier.php', 'supplier'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-truck-field"></i>
      <span>Supplier</span>
    </a>

    <a href="/backend/admin/customer/data_customer.php" 
       class="bento-pill-tab <?= is_bento_active(['data_customer.php', 'tambah_data_customer.php', 'edit_customer.php', 'customer'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-users"></i>
      <span>Customer</span>
    </a>

    <a href="/backend/admin/pembelian/transaksi_pembelian.php" 
       class="bento-pill-tab <?= is_bento_active(['transaksi_pembelian.php', 'pembelian_barang.php', 'detail_pembelian.php', 'pembelian'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-cart-shopping"></i>
      <span>Pembelian</span>
    </a>

    <a href="/backend/admin/penjualan/detail_penjualan.php" 
       class="bento-pill-tab <?= is_bento_active(['input_penjualan.php', 'detail_penjualan.php', 'penjualan'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-receipt"></i>
      <span>Penjualan</span>
    </a>

    <a href="/backend/admin/kategori/data_kategori.php" 
       class="bento-pill-tab <?= is_bento_active(['data_kategori.php', 'tambah_data_kategori.php', 'edit_kategori.php', 'kategori'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-tags"></i>
      <span>Kategori</span>
    </a>

    <a href="/backend/admin/karyawan/data_karyawan.php" 
       class="bento-pill-tab <?= is_bento_active(['data_karyawan.php', 'tambah_data_karyawan.php', 'edit_karyawan.php', 'karyawan'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-user-gear"></i>
      <span>Karyawan</span>
    </a>

    <a href="/backend/admin/laporan/laporan_transaksi.php" 
       class="bento-pill-tab <?= is_bento_active(['laporan_transaksi.php', 'laporan'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-chart-line"></i>
      <span>Laporan</span>
    </a>

    <a href="/backend/admin/log/log_aktivitas.php" 
       class="bento-pill-tab <?= is_bento_active(['log_aktivitas.php', 'log'], $current_page, $current_dir) ? 'active' : '' ?>">
      <i class="fa-solid fa-clock-rotate-left"></i>
      <span>Audit Log</span>
    </a>
  </nav>

  <!-- User & Actions -->
  <div class="bento-user-area">
    <!-- Cloud Status Badge -->
    <div class="bento-filter-pill" style="padding: 5px 12px; font-size: 0.75rem;" title="PostgreSQL Supabase Connected">
      <span class="bento-pulse-dot"></span>
      <span class="d-none d-md-inline" style="color: var(--c-mint);">Supabase</span>
    </div>

    <!-- User Pill -->
    <div class="bento-user-pill">
      <div class="bento-user-avatar">
        <?= strtoupper(substr($active_user, 0, 1)) ?>
      </div>
      <span class="bento-user-name d-none d-sm-inline">
        <?= htmlspecialchars($active_user) ?>
      </span>
    </div>

    <!-- Logout -->
    <a href="/proses.php?action=logout" class="bento-icon-pill" title="Logout" onclick="return confirm('Keluar dari aplikasi?');">
      <i class="fa-solid fa-arrow-right-from-bracket" style="color: #ef4444;"></i>
    </a>
  </div>
</header>
