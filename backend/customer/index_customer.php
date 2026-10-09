<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Customer') {
    header("Location: /login.php");
    exit();
}
include_once __DIR__ . '/../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

$cust_email = $_SESSION['username'];
$cust_res = pg_query($conn, "SELECT * FROM tb_customer WHERE email_customer = '$cust_email'");
$customer = ($cust_res && pg_num_rows($cust_res) > 0) ? pg_fetch_assoc($cust_res) : null;
$id_customer = $customer['id_customer'] ?? $_SESSION['user_id'] ?? '';
$nama_customer = $customer['nama_customer'] ?? $cust_email;
$_SESSION['nama_customer'] = $nama_customer;

// Riwayat Pembelian / Pesanan Customer
$orders_res = pg_query($conn, "SELECT * FROM tb_penjualan WHERE id_customer = '$id_customer' ORDER BY tanggal_penjualan DESC");
$total_orders = $orders_res ? pg_num_rows($orders_res) : 0;
$total_spend = 0;
$orders_list = [];

if ($orders_res) {
    while ($row = pg_fetch_assoc($orders_res)) {
        $total_spend += (float)($row['total_hargaall'] ?? 0);
        $orders_list[] = $row;
    }
}

// Katalog Produk Tersedia di Gudang
$catalog_res = pg_query($conn, "SELECT b.*, COALESCE(k.nama_kategori, b.kode_jenis, 'Umum') as kategori FROM tb_barang b LEFT JOIN kategori_barang k ON b.kode_jenis = k.id_kategori ORDER BY b.kd_barang ASC LIMIT 6");
$catalog_items = [];
if ($catalog_res) {
    while ($r = pg_fetch_assoc($catalog_res)) {
        $catalog_items[] = $r;
    }
}

// Total barang ready di gudang
$cnt_barang_res = pg_query($conn, "SELECT COUNT(*), SUM(stok) FROM tb_barang WHERE stok > 0");
$total_sku_ready = 0;
$total_stok_ready = 0;
if ($cnt_barang_res && $row = pg_fetch_row($cnt_barang_res)) {
    $total_sku_ready = (int)$row[0];
    $total_stok_ready = (int)$row[1];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portal Pelanggan - SIMTI Inventory</title>
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/clean-ui.css">
    <style>
      .customer-banner {
        background: linear-gradient(135deg, #0b2b26 0%, #051F20 100%);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-bento);
        padding: 36px 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-bento);
      }
      .customer-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--c-lime) 0%, var(--c-mint) 100%);
      }
    </style>
</head>
<body>

    <!-- Top Capsule Navigation -->
    <?php include_once __DIR__ . '/navbar.php'; ?>

    <main class="bento-container">
        
        <!-- Welcome Banner -->
        <div class="customer-banner">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 8px; padding: 4px 14px; border-radius: var(--radius-pill); background: rgba(163, 230, 53, 0.15); border: 1px solid rgba(163, 230, 53, 0.3); color: var(--c-lime); font-size: 0.775rem; font-weight: 700; margin-bottom: 14px;">
                        <span class="bento-pulse-dot"></span>
                        <span>Portal Pelanggan SIMTI</span>
                    </div>
                    <h1 style="color: #ffffff; font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; margin: 0 0 8px 0; letter-spacing: -0.03em;">
                        Selamat Datang, <?= htmlspecialchars($nama_customer) ?>!
                    </h1>
                    <p style="color: var(--c-sage); margin: 0; font-size: 0.925rem; max-width: 600px; line-height: 1.6;">
                        Pantau riwayat pemesanan barang, cek invoice transaksi, dan jelajahi ketersediaan stok produk langsung dari gudang pusat kami.
                    </p>
                </div>

                <div style="display: flex; gap: 10px; align-items: center;">
                    <a href="katalog.php" class="bento-btn bento-btn-lime">
                        <i class="fa-solid fa-cart-plus"></i> Jelajahi Katalog
                    </a>
                </div>
            </div>
        </div>

        <!-- Bento Metrics Grid (Image 1 Style) -->
        <div class="bento-grid-metrics">
            <div class="bento-subgrid-metrics">
                
                <!-- Metric 1: Total Orders -->
                <div class="bento-card">
                    <div class="bento-card-label">Total Pesanan Saya</div>
                    <div class="bento-card-value"><?= number_format($total_orders) ?> <span style="font-size: 1rem; color: var(--c-sage);">Invoice</span></div>
                    <div class="bento-progress-track">
                        <div class="bento-progress-fill" style="width: <?= min(100, $total_orders * 25) ?>%;"></div>
                    </div>
                    <div class="bento-card-sub" style="margin-top: 10px;">
                        <i class="fa-solid fa-receipt" style="color: var(--c-lime);"></i>
                        <span>Tercatat di sistem PostgreSQL</span>
                    </div>
                </div>

                <!-- Metric 2: Total Spent -->
                <div class="bento-card">
                    <div class="bento-card-label">Total Nilai Belanja</div>
                    <div class="bento-card-value" style="font-size: 1.55rem; color: var(--c-mint);">
                        Rp <?= number_format($total_spend, 0, ',', '.') ?>
                    </div>
                    <div class="bento-progress-track">
                        <div class="bento-progress-fill" style="width: 75%;"></div>
                    </div>
                    <div class="bento-card-sub" style="margin-top: 10px;">
                        <i class="fa-solid fa-wallet" style="color: var(--c-mint);"></i>
                        <span>Akumulasi transaksi selesai</span>
                    </div>
                </div>

                <!-- Metric 3: Ready Products -->
                <div class="bento-card">
                    <div class="bento-card-label">Produk Ready Stock</div>
                    <div class="bento-card-value"><?= number_format($total_sku_ready) ?> <span style="font-size: 1rem; color: var(--c-sage);">SKU</span></div>
                    <div class="bento-progress-track">
                        <div class="bento-progress-fill" style="width: 90%;"></div>
                    </div>
                    <div class="bento-card-sub" style="margin-top: 10px;">
                        <i class="fa-solid fa-boxes-stacked" style="color: var(--c-lime);"></i>
                        <span><?= number_format($total_stok_ready) ?> unit siap kirim</span>
                    </div>
                </div>

            </div>

            <!-- Metric 4: Account Status Highlight Card -->
            <div class="bento-card-highlight" style="background: linear-gradient(145deg, #163832 0%, #0b2b26 100%);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--c-sage);">ID Pelanggan</div>
                        <div style="font-size: 1.35rem; font-weight: 800; color: #ffffff; font-family: var(--font-mono); margin-top: 4px;">
                            #<?= htmlspecialchars($id_customer) ?>
                        </div>
                    </div>
                    <span class="bento-lime-badge">
                        <i class="fa-solid fa-check-circle"></i> Terverifikasi
                    </span>
                </div>

                <div style="margin: 16px 0; background: var(--c-forest-700); border: 1px solid var(--border-glass); border-radius: 12px; padding: 12px;">
                    <div style="font-size: 0.725rem; color: var(--c-sage);">Email Terdaftar</div>
                    <div style="font-size: 0.85rem; font-weight: 700; color: #ffffff; word-break: break-all; margin-top: 2px;">
                        <?= htmlspecialchars($cust_email) ?>
                    </div>
                    <div style="font-size: 0.725rem; color: var(--c-sage); margin-top: 8px;">Telepon: <strong style="color: var(--c-mint);"><?= htmlspecialchars($customer['telepon_customer'] ?? '-') ?></strong></div>
                </div>

                <a href="pesanan.php" class="bento-btn bento-btn-white" style="width: 100%; justify-content: center; font-size: 0.825rem; padding: 8px 16px;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Lihat Riwayat Pesanan
                </a>
            </div>
        </div>

        <!-- ========================================================
             SIGNATURE BENTO SPLIT SECTION (Image 1 Style)
             ======================================================== -->
        <div class="bento-split-grid" style="margin-bottom: 28px;">
            
            <!-- Left Side: Pale Mint Card (Riwayat Pesanan Terbaru) -->
            <div class="bento-card-light">
                <div class="bento-section-title">
                    <span>Riwayat Pesanan Saya</span>
                    <span style="font-size: 0.725rem; font-weight: 700; background: var(--c-forest-900); color: var(--c-mint); padding: 4px 10px; border-radius: var(--radius-pill); font-family: var(--font-mono);">
                        <?= count($orders_list) ?> Transaksi
                    </span>
                </div>

                <?php if (!empty($orders_list)): ?>
                    <div class="bento-light-list">
                        <?php foreach (array_slice($orders_list, 0, 4) as $ord): ?>
                            <div class="bento-light-item">
                                <div class="bento-light-item-left">
                                    <div class="bento-light-avatar" style="background: var(--c-forest-900); color: var(--c-lime);">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </div>
                                    <div>
                                        <div class="bento-light-name"><?= htmlspecialchars($ord['no_penjualan']) ?></div>
                                        <div class="bento-light-meta"><?= htmlspecialchars($ord['tanggal_penjualan']) ?> &bull; <?= (int)$ord['total_barangall'] ?> item dibeli</div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div class="bento-light-price">
                                        Rp <?= number_format((float)$ord['total_hargaall'], 0, ',', '.') ?>
                                    </div>
                                    <span class="bento-status-pill bento-status-safe" style="font-size: 0.7rem; padding: 2px 8px;">
                                        Selesai
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 36px 20px; color: #64748b;">
                        <i class="fa-solid fa-cart-shopping" style="font-size: 36px; margin-bottom: 12px; opacity: 0.4;"></i>
                        <div style="font-weight: 700; color: var(--c-forest-900);">Belum ada riwayat transaksi</div>
                        <p style="font-size: 0.85rem; margin-top: 4px;">Pilih produk di katalog untuk mulai melakukan pemesanan.</p>
                        <a href="katalog.php" class="bento-btn bento-btn-lime" style="font-size: 0.8rem; margin-top: 10px;">
                            Buka Katalog Sekarang
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Side: Deep Forest Dark Card (Alamat & Info Akun) -->
            <div class="bento-card-dark">
                <div class="bento-section-title">
                    <span>Informasi Pengiriman &amp; Profil</span>
                    <span style="font-size: 0.75rem; color: var(--c-lime); font-family: var(--font-mono);">
                        <i class="fa-solid fa-shield-halved"></i> Data Aman
                    </span>
                </div>

                <div class="bento-dark-grid">
                    <div class="bento-metric-tile">
                        <div class="bento-tile-label">Nama Pemilik Akun</div>
                        <div class="bento-tile-value" style="font-size: 1.05rem; color: #ffffff;">
                            <?= htmlspecialchars($nama_customer) ?>
                        </div>
                    </div>

                    <div class="bento-metric-tile">
                        <div class="bento-tile-label">Jenis Kelamin</div>
                        <div class="bento-tile-value" style="font-size: 1.05rem; color: var(--c-mint);">
                            <?= htmlspecialchars($customer['jenis_kelamin'] ?? 'Lainnya') ?>
                        </div>
                    </div>

                    <div class="bento-metric-tile" style="grid-column: span 2;">
                        <div class="bento-tile-label">Alamat Domisili / Pengiriman</div>
                        <div style="color: var(--c-mint); font-size: 0.9rem; line-height: 1.5; margin-top: 4px;">
                            <i class="fa-solid fa-location-dot" style="color: var(--c-lime); margin-right: 6px;"></i>
                            <?= htmlspecialchars($customer['alamat_customer'] ?? 'Belum ada alamat pengiriman tersimpan') ?>
                        </div>
                    </div>
                </div>

                <div style="background: var(--c-forest-700); border: 1px solid var(--border-glass); border-radius: var(--radius-bento-sm); padding: 16px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: #ffffff;">Layanan Customer Support</span>
                        <span style="font-size: 0.725rem; color: var(--c-lime); font-weight: 700;">Online (08:00 - 17:00)</span>
                    </div>
                    <div style="font-size: 0.775rem; color: var(--c-sage);">
                        Butuh bantuan seputar pemesanan produk atau faktur? Hubungi admin gudang melalui portal ini.
                    </div>
                </div>

                <a href="katalog.php" class="bento-btn bento-btn-lime" style="width: 100%; justify-content: center;">
                    <i class="fa-solid fa-bag-shopping"></i> Pesan Produk Baru
                </a>
            </div>

        </div>

        <!-- ========================================================
             KATALOG PRODUK READY STOCK PREVIEW
             ======================================================== -->
        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: #ffffff; font-size: 1.15rem; font-weight: 800; margin: 0;">Katalog Produk Unggulan</h3>
                    <p style="color: var(--c-sage); font-size: 0.8rem; margin: 4px 0 0 0;">Barang ready stock di gudang pusat yang dapat dipesan</p>
                </div>
                <a href="katalog.php" class="bento-btn bento-btn-dark" style="font-size: 0.8rem;">
                    <span>Lihat Seluruh Katalog</span> <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>Kode SKU</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Ketersediaan Stok</th>
                            <th>Harga Satuan</th>
                            <th style="text-align: right;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($catalog_items as $c): ?>
                            <tr>
                                <td style="font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                                    <?= htmlspecialchars($c['kd_barang']) ?>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #ffffff;"><?= htmlspecialchars($c['nama_barang']) ?></div>
                                </td>
                                <td>
                                    <span style="font-size: 0.775rem; padding: 3px 10px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint); border: 1px solid var(--border-glass);">
                                        <?= htmlspecialchars($c['kategori']) ?>
                                    </span>
                                </td>
                                <td style="font-family: var(--font-mono); font-weight: 700; color: #ffffff;">
                                    <?= number_format((int)$c['stok']) ?> Unit
                                </td>
                                <td style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);">
                                    Rp <?= number_format((float)$c['harga_jual'], 0, ',', '.') ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php if ((int)$c['stok'] > 10): ?>
                                        <span class="bento-status-pill bento-status-safe">
                                            <i class="fa-solid fa-check"></i> Ready Stock
                                        </span>
                                    <?php else: ?>
                                        <span class="bento-status-pill bento-status-low">
                                            <i class="fa-solid fa-clock"></i> Stok Terbatas
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <?php include_once __DIR__ . '/../../include/footer.php'; ?>

</body>
</html>
