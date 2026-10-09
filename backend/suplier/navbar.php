<?php
$current_page = basename($_SERVER['PHP_SELF']);
$supplier_user = $_SESSION['username'] ?? 'Supplier';
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
    background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);
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
  }

  .sidebar-nav .nav-link:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #ffffff;
    transform: translateX(3px);
  }

  .sidebar-nav .nav-link:hover i {
    color: #38bdf8;
  }

  .sidebar-nav .nav-item.active .nav-link {
    background: #0ea5e9;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);
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
    background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
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
    color: #38bdf8;
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
    <div class="sidebar-brand-wrapper">
      <a class="brand-logo-container" href="/backend/suplier/index_suplier.php">
        <div class="brand-logo-icon">
          <i class="fa-solid fa-truck"></i>
        </div>
        <div>
          <div class="brand-logo-text">SIMTI</div>
          <div class="brand-logo-sub">Portal Supplier</div>
        </div>
      </a>
    </div>

    <ul class="sidebar-nav">
      <li class="nav-section-title">Menu Utama</li>
      <li class="nav-item <?= ($current_page == 'index_suplier.php') ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/suplier/index_suplier.php">
          <i class="fa-solid fa-chart-pie"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-section-title">Pesanan Stok</li>
      <li class="nav-item <?= in_array($current_page, ['transaksi_pembelian.php', 'detail_pembelian.php']) ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/suplier/pembelian/transaksi_pembelian.php">
          <i class="fa-solid fa-clipboard-check"></i>
          <span>Purchase Order (PO)</span>
        </a>
      </li>
      <li class="nav-item <?= ($current_page == 'pembelian_barang.php') ? 'active' : '' ?>">
        <a class="nav-link" href="/backend/suplier/pembelian/pembelian_barang.php">
          <i class="fa-solid fa-box-open"></i>
          <span>Pengiriman Barang</span>
        </a>
      </li>
    </ul>
  </div>

  <div class="sidebar-user-footer">
    <div class="user-info-wrap">
      <div class="user-avatar-pill">
        <?= strtoupper(substr($supplier_user, 0, 1)) ?>
      </div>
      <div>
        <div class="user-name-text"><?= htmlspecialchars($supplier_user) ?></div>
        <div class="user-role-badge">● Mitra Supplier</div>
      </div>
    </div>
    <a href="/proses.php?action=logout" class="logout-btn-link" title="Keluar / Logout" onclick="return confirm('Apakah Anda yakin ingin logout?');">
      <i class="fa-solid fa-arrow-right-from-bracket"></i>
    </a>
  </div>
</nav>