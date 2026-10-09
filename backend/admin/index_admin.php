<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Administrator') {
    header("Location: /login.php");
    exit();
}

require_once __DIR__ . '/../../koneksi.php';

// Ambil Statistik Live dari Database Supabase
$total_barang = 0;
$total_stok = 0;
$total_supplier = 0;
$total_customer = 0;
$total_pembelian = 0;
$total_penjualan = 0;

$res_b = pg_query($conn, "SELECT COUNT(*) as c, COALESCE(SUM(stok), 0) as s FROM tb_barang");
if ($res_b && $row = pg_fetch_assoc($res_b)) {
    $total_barang = (int)$row['c'];
    $total_stok = (int)$row['s'];
}

$res_s = pg_query($conn, "SELECT COUNT(*) as c FROM tb_supplier");
if ($res_s && $row = pg_fetch_assoc($res_s)) {
    $total_supplier = (int)$row['c'];
}

$res_c = pg_query($conn, "SELECT COUNT(*) as c FROM tb_customer");
if ($res_c && $row = pg_fetch_assoc($res_c)) {
    $total_customer = (int)$row['c'];
}

$res_p = pg_query($conn, "SELECT COUNT(*) as c FROM tb_pembelian");
if ($res_p && $row = pg_fetch_assoc($res_p)) {
    $total_pembelian = (int)$row['c'];
}

$res_j = pg_query($conn, "SELECT COUNT(*) as c FROM tb_penjualan");
if ($res_j && $row = pg_fetch_assoc($res_j)) {
    $total_penjualan = (int)$row['c'];
}

// Data Barang Terbaru
$barang_list = pg_query($conn, "SELECT * FROM tb_barang ORDER BY stok ASC LIMIT 5");

// Hitung barang dengan stok menipis (<= 10)
$res_low = pg_query($conn, "SELECT COUNT(*) as c FROM tb_barang WHERE stok <= 10");
$low_stock_count = ($res_low && $row_low = pg_fetch_assoc($res_low)) ? (int)$row_low['c'] : 0;

// Data Supplier Terkini
$supplier_list = pg_query($conn, "SELECT * FROM tb_supplier ORDER BY id_supplier DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Inventory Dashboard - SIMTI</title>
  <link rel="icon" type="image/png" href="/assets/images/favicon.png">

  <!-- Google Fonts & Font Awesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/clean-ui.css">
</head>
<body>

  <!-- Top Segmented Capsule Navigation (Persis Image 1) -->
  <?php include_once __DIR__ . '/../../include/bento_header.php'; ?>

  <!-- Main Bento Content Container -->
  <main class="bento-container">
    
    <!-- Title & Top Actions Row -->
    <div class="bento-header-row">
      <div style="display: flex; align-items: center; gap: 14px;">
        <h1 class="bento-title">Inventory Overview</h1>
      </div>

      <div style="display: flex; align-items: center; gap: 10px;">
        <a href="/backend/admin/pembelian/transaksi_pembelian.php" class="bento-btn bento-btn-dark">
          <i class="fa-solid fa-cart-shopping"></i>
          <span>Transaksi</span>
        </a>
        <a href="/backend/admin/barang/tambah_data_barang.php" class="bento-btn bento-btn-lime">
          <i class="fa-solid fa-plus"></i>
          <span>Tambah Barang</span>
        </a>
      </div>
    </div>

    <!-- Top Bento Metrics Grid -->
    <div class="bento-grid-metrics">
      
      <!-- Left Subgrid: 3 Dark Cards (Image 1 Style) -->
      <div class="bento-subgrid-metrics">
        
        <!-- Metric 1: Total Stok Unit -->
        <div class="bento-card">
          <div class="bento-card-label">Total Unit Fisik</div>
          <div class="bento-card-value"><?= number_format($total_stok) ?> <span style="font-size: 1rem; color: var(--text-sage); font-weight: 500;">Unit</span></div>
          <div class="bento-card-sub">
            <i class="fa-solid fa-boxes-stacked" style="color: var(--c-lime);"></i>
            <span>Tersimpan di gudang</span>
          </div>
          <div class="bento-progress-track">
            <div class="bento-progress-fill" style="width: 78%;"></div>
          </div>
          <div class="bento-avatar-stack">
            <div class="bento-stack-item">K1</div>
            <div class="bento-stack-item">K2</div>
            <div class="bento-stack-item">K3</div>
          </div>
        </div>

        <!-- Metric 2: Master Barang -->
        <div class="bento-card">
          <div class="bento-card-label">Item Terdaftar</div>
          <div class="bento-card-value"><?= number_format($total_barang) ?> <span style="font-size: 1rem; color: var(--text-sage); font-weight: 500;">SKU</span></div>
          <div class="bento-card-sub">
            <i class="fa-solid fa-tags" style="color: var(--c-sage);"></i>
            <span>Katalog Master Aktif</span>
          </div>
          <div class="bento-progress-track">
            <div class="bento-progress-fill" style="width: 62%; background: var(--c-sage);"></div>
          </div>
          <div style="font-size: 0.775rem; color: var(--text-muted); margin-top: 14px;">
            Terhubung Supabase Cloud
          </div>
        </div>

        <!-- Metric 3: Mitra Jaringan -->
        <div class="bento-card">
          <div class="bento-card-label">Mitra & Customer</div>
          <div class="bento-card-value"><?= number_format($total_supplier + $total_customer) ?></div>
          <div class="bento-card-sub">
            <i class="fa-solid fa-users" style="color: #38bdf8;"></i>
            <span><?= $total_supplier ?> Supplier &bull; <?= $total_customer ?> Customer</span>
          </div>
          <div class="bento-progress-track">
            <div class="bento-progress-fill" style="width: 85%; background: #38bdf8;"></div>
          </div>
          <div style="font-size: 0.775rem; color: var(--text-muted); margin-top: 14px;">
            Sinkronisasi Realtime
          </div>
        </div>

      </div>

      <!-- Right Card: Electric Lime Featured Card (Directly from Image 1!) -->
      <div class="bento-card-highlight">
        <div>
          <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
            <div class="bento-card-label" style="color: var(--c-mint);">Restock Alert</div>
            <span class="bento-lime-badge">
              <i class="fa-solid fa-bell"></i>
              <span>Live Warning</span>
            </span>
          </div>
          
          <div style="font-size: 2.25rem; font-weight: 800; color: #ffffff; line-height: 1.1; margin-bottom: 6px;">
            <?= $low_stock_count ?> Barang
          </div>
          <p style="font-size: 0.825rem; color: var(--text-sage); line-height: 1.5; margin-bottom: 20px;">
            <?= ($low_stock_count > 0) ? "Perlu pemesanan ulang ke supplier karena stok tersisa <= 10 unit." : "Seluruh stok barang dalam kondisi aman terkendali."; ?>
          </p>
        </div>

        <div>
          <a href="/backend/admin/barang/data_stok.php" class="bento-btn bento-btn-lime" style="width: 100%; justify-content: center;">
            <span>Kelola Stok Barang</span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>

    </div>

    <!-- Capsule Filter Bar (Image 1 Style) -->
    <div class="bento-filters-row">
      <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-sage); margin-right: 4px;">
        Filter Cepat:
      </span>
      <a href="/backend/admin/barang/data_barang.php" class="bento-filter-pill active">
        <i class="fa-solid fa-boxes-stacked"></i> Semua Barang
      </a>
      <a href="/backend/admin/barang/data_stok.php" class="bento-filter-pill">
        <i class="fa-solid fa-triangle-exclamation"></i> Stok Kritis (<= 10)
      </a>
      <a href="/backend/admin/supplier/data_supplier.php" class="bento-filter-pill">
        <i class="fa-solid fa-truck"></i> Mitra Supplier
      </a>
      <a href="/backend/admin/customer/data_customer.php" class="bento-filter-pill">
        <i class="fa-solid fa-users"></i> Data Customer
      </a>
      <a href="/backend/admin/pembelian/transaksi_pembelian.php" class="bento-filter-pill">
        <i class="fa-solid fa-calendar"></i> Transaksi Terkini
      </a>
    </div>

    <!-- The Signature Bento Split: Light Bento Card vs Dark Bento Card (Image 1 Bottom) -->
    <div class="bento-split-grid">
      
      <!-- LEFT: The Contrasting Pale Mint / Crisp Card -->
      <div class="bento-card-light">
        <div class="bento-section-title">
          <span>Stok Inventaris Utama</span>
          <a href="/backend/admin/barang/data_barang.php" style="font-size: 0.8rem; font-weight: 700; color: var(--c-forest-900); text-decoration: underline;">
            Lihat Semua
          </a>
        </div>

        <div class="bento-light-list">
          <?php if ($barang_list && pg_num_rows($barang_list) > 0): ?>
            <?php while ($b = pg_fetch_assoc($barang_list)): ?>
              <div class="bento-light-item">
                <div class="bento-light-item-left">
                  <div class="bento-light-avatar">
                    <i class="fa-solid fa-box-open"></i>
                  </div>
                  <div>
                    <div class="bento-light-name"><?= htmlspecialchars($b['nama_barang']) ?></div>
                    <div class="bento-light-meta">#<?= htmlspecialchars($b['kd_barang']) ?> &bull; Sisa: <strong><?= (int)$b['stok'] ?> Unit</strong></div>
                  </div>
                </div>

                <div style="text-align: right;">
                  <div class="bento-light-price">Rp <?= number_format($b['harga_jual'] ?? 0, 0, ',', '.') ?></div>
                  <div>
                    <?php if (($b['stok'] ?? 0) <= 10): ?>
                      <span class="bento-status-pill bento-status-low">Menipis</span>
                    <?php else: ?>
                      <span class="bento-status-pill bento-status-safe">Aman</span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <div style="text-align: center; padding: 24px; color: #64748b;">
              Belum ada data barang di database.
            </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- RIGHT: The Deep Dark Bento Card -->
      <div class="bento-card-dark">
        <div class="bento-section-title">
          <span>Ringkasan Transaksi & Cloud</span>
          <span class="bento-filter-pill" style="padding: 4px 10px; font-size: 0.725rem;">
            <span class="bento-pulse-dot"></span> PostgreSQL Live
          </span>
        </div>

        <!-- 4 Sub-Tiles -->
        <div class="bento-dark-grid">
          <div class="bento-metric-tile">
            <div class="bento-tile-label">Total Pembelian (PO)</div>
            <div class="bento-tile-value"><?= number_format($total_pembelian) ?></div>
            <div style="font-size: 0.75rem; color: var(--text-sage); margin-top: 4px;">Pemesanan stok</div>
          </div>

          <div class="bento-metric-tile">
            <div class="bento-tile-label">Total Penjualan</div>
            <div class="bento-tile-value"><?= number_format($total_penjualan) ?></div>
            <div style="font-size: 0.75rem; color: var(--text-sage); margin-top: 4px;">Faktur terbit</div>
          </div>

          <div class="bento-metric-tile">
            <div class="bento-tile-label">Mitra Supplier</div>
            <div class="bento-tile-value"><?= number_format($total_supplier) ?></div>
            <div style="font-size: 0.75rem; color: var(--text-sage); margin-top: 4px;">Vendor terverifikasi</div>
          </div>

          <div class="bento-metric-tile">
            <div class="bento-tile-label">Pelanggan Aktif</div>
            <div class="bento-tile-value"><?= number_format($total_customer) ?></div>
            <div style="font-size: 0.75rem; color: var(--text-sage); margin-top: 4px;">Akun terhubung</div>
          </div>
        </div>

        <!-- Detail Box -->
        <div style="background: var(--c-forest-700); border: 1px solid var(--border-glass); border-radius: var(--radius-bento-sm); padding: 18px; margin-bottom: 20px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.85rem; color: var(--text-sage);">Status Sinkronisasi</span>
            <span style="font-size: 0.85rem; font-weight: 700; color: var(--c-lime); font-family: var(--font-mono);">ONLINE 100%</span>
          </div>
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 0.85rem; color: var(--text-sage);">Server Region</span>
            <span style="font-size: 0.85rem; font-weight: 600; color: var(--text-white);">Tokyo (ap-northeast-1)</span>
          </div>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.85rem; color: var(--text-sage);">Vercel Deployment Ready</span>
            <span style="font-size: 0.85rem; font-weight: 600; color: var(--c-mint);">Siap Deploy</span>
          </div>
        </div>

        <div style="display: flex; gap: 10px;">
          <a href="/backend/admin/pembelian/pembelian_barang.php" class="bento-btn bento-btn-lime" style="flex: 1; justify-content: center;">
            <i class="fa-solid fa-plus"></i> Input Pembelian Stok
          </a>
          <a href="/backend/admin/penjualan/input_penjualan.php" class="bento-btn bento-btn-white" style="flex: 1; justify-content: center;">
            <i class="fa-solid fa-receipt"></i> Input Penjualan
          </a>
        </div>
      </div>

    </div>

  </main>

  <!-- Clean Footer -->
  <footer style="text-align: center; padding: 24px; border-top: 1px solid var(--border-glass); font-size: 0.825rem; color: var(--text-muted);">
    &copy; <?= date('Y') ?> <strong>SIMTI Inventory</strong> &bull; Terintegrasi dengan <strong>Supabase PostgreSQL</strong>
  </footer>

</body>
</html>