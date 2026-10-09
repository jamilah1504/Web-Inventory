<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
$sup_name = $_SESSION['nama_supplier'] ?? $_SESSION['username'] ?? 'Mitra Supplier';
$sup_email = $_SESSION['username'] ?? 'supplier@mail.com';
?>
<!-- SUPPLIER TOP CAPSULE NAVIGATION (Bento Style) -->
<header class="bento-nav-wrapper">
  <!-- Brand -->
  <a href="/backend/suplier/index_suplier.php" class="bento-brand">
    <img src="/assets/images/logo.png" alt="SIMTI Logo" style="width: 38px; height: 38px; border-radius: 12px; object-fit: contain; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);">
    <div>
      <div class="bento-brand-name">SIMTI</div>
    </div>
  </a>

  <!-- Floating Segmented Pill Capsule -->
  <nav class="bento-pill-capsule">
    <a href="/backend/suplier/index_suplier.php" 
       class="bento-pill-tab <?= ($current_page == 'index_suplier.php') ? 'active' : '' ?>">
      <i class="fa-solid fa-chart-pie"></i>
      <span>Dashboard</span>
    </a>

    <a href="/backend/suplier/pembelian/transaksi_pembelian.php" 
       class="bento-pill-tab <?= in_array($current_page, ['transaksi_pembelian.php', 'detail_pembelian.php', 'edit_pembelian.php']) ? 'active' : '' ?>">
      <i class="fa-solid fa-file-invoice-dollar"></i>
      <span>Pesanan Masuk (PO)</span>
    </a>

    <a href="/backend/suplier/pembelian/pembelian_barang.php" 
       class="bento-pill-tab <?= ($current_page == 'pembelian_barang.php') ? 'active' : '' ?>">
      <i class="fa-solid fa-truck-fast"></i>
      <span>Kirim Pasokan Baru</span>
    </a>
  </nav>

  <!-- User & Actions -->
  <div class="bento-user-area">
    <div class="bento-user-pill">
      <div class="bento-user-avatar" style="background: linear-gradient(135deg, var(--c-forest-600) 0%, var(--c-lime) 100%); color: var(--c-forest-900);">
        <i class="fa-solid fa-building" style="font-size: 0.8rem;"></i>
      </div>
      <div>
        <div class="bento-user-name"><?= htmlspecialchars($sup_name) ?></div>
        <div style="font-size: 0.675rem; color: var(--c-lime); font-family: var(--font-mono);">Mitra Supplier</div>
      </div>
    </div>

    <!-- Logout Pill -->
    <a href="/proses.php?action=logout" class="bento-icon-pill" title="Logout" 
       onclick="return confirm('Keluar dari portal supplier?')"
       style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.25); color: #f87171;">
      <i class="fa-solid fa-power-off"></i>
    </a>
  </div>
</header>