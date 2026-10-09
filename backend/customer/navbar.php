<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
$cust_name = $_SESSION['nama_customer'] ?? $_SESSION['username'] ?? 'Pelanggan';
$cust_email = $_SESSION['username'] ?? 'customer@mail.com';
?>
<!-- CUSTOMER TOP CAPSULE NAVIGATION (Bento Style) -->
<header class="bento-nav-wrapper">
  <!-- Brand -->
  <a href="/backend/customer/index_customer.php" class="bento-brand">
    <div class="bento-brand-icon">
      <i class="fa-solid fa-bag-shopping"></i>
    </div>
    <div>
      <div class="bento-brand-name">SIMTI</div>
    </div>
  </a>

  <!-- Floating Segmented Pill Capsule -->
  <nav class="bento-pill-capsule">
    <a href="/backend/customer/index_customer.php" 
       class="bento-pill-tab <?= ($current_page == 'index_customer.php') ? 'active' : '' ?>">
      <i class="fa-solid fa-chart-pie"></i>
      <span>Dashboard</span>
    </a>

    <a href="/backend/customer/katalog.php" 
       class="bento-pill-tab <?= ($current_page == 'katalog.php') ? 'active' : '' ?>">
      <i class="fa-solid fa-cubes"></i>
      <span>Katalog Produk</span>
    </a>

    <a href="/backend/customer/pesanan.php" 
       class="bento-pill-tab <?= ($current_page == 'pesanan.php') ? 'active' : '' ?>">
      <i class="fa-solid fa-receipt"></i>
      <span>Pesanan Saya</span>
    </a>
  </nav>

  <!-- User & Actions -->
  <div class="bento-user-area">
    <div class="bento-user-pill">
      <div class="bento-user-avatar" style="background: linear-gradient(135deg, var(--c-lime) 0%, var(--c-mint) 100%);">
        <i class="fa-solid fa-user" style="color: var(--c-forest-900); font-size: 0.8rem;"></i>
      </div>
      <div>
        <div class="bento-user-name"><?= htmlspecialchars($cust_name) ?></div>
        <div style="font-size: 0.675rem; color: var(--c-sage); font-family: var(--font-mono);">Customer</div>
      </div>
    </div>

    <!-- Logout Pill -->
    <a href="/proses.php?action=logout" class="bento-icon-pill" title="Logout" 
       onclick="return confirm('Keluar dari portal customer?')"
       style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.25); color: #f87171;">
      <i class="fa-solid fa-power-off"></i>
    </a>
  </div>
</header>
