<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Supplier') {
    header("Location: /login.php");
    exit();
}
require_once __DIR__ . '/../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

$sup_email = $_SESSION['username'];
$res_sup = pg_query($conn, "SELECT * FROM tb_supplier WHERE email_supplier = '$sup_email'");
$supplier = ($res_sup && pg_num_rows($res_sup) > 0) ? pg_fetch_assoc($res_sup) : null;
$id_supplier = $supplier['id_supplier'] ?? $_SESSION['user_id'] ?? '';
$nama_supplier = $supplier['nama_supplier'] ?? $sup_email;
$_SESSION['nama_supplier'] = $nama_supplier;

// PO Pesanan dari Admin untuk Supplier ini
$po_res = pg_query($conn, "SELECT * FROM tb_pembelian WHERE id_supplier = '$id_supplier' ORDER BY no_pembelian DESC");
$total_po = $po_res ? pg_num_rows($po_res) : 0;
$total_nilai_pasokan = 0;
$total_unit_kirim = 0;
$po_list = [];

if ($po_res) {
    while ($row = pg_fetch_assoc($po_res)) {
        $total_nilai_pasokan += (float)($row['total_hargaall'] ?? 0);
        $total_unit_kirim += (int)($row['total_barangall'] ?? 0);
        $po_list[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portal Supplier - SIMTI Inventory</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/clean-ui.css">
    <style>
      .supplier-banner {
        background: linear-gradient(135deg, #0b2b26 0%, #051F20 100%);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-bento);
        padding: 36px 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-bento);
      }
      .supplier-banner::before {
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
        <div class="supplier-banner">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 8px; padding: 4px 14px; border-radius: var(--radius-pill); background: rgba(163, 230, 53, 0.15); border: 1px solid rgba(163, 230, 53, 0.3); color: var(--c-lime); font-size: 0.775rem; font-weight: 700; margin-bottom: 14px;">
                        <span class="bento-pulse-dot"></span>
                        <span>Portal Mitra Supplier Aktif</span>
                    </div>
                    <h1 style="color: #ffffff; font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; margin: 0 0 8px 0; letter-spacing: -0.03em;">
                        Selamat Datang, <?= htmlspecialchars($nama_supplier) ?>!
                    </h1>
                    <p style="color: var(--c-sage); margin: 0; font-size: 0.925rem; max-width: 600px; line-height: 1.6;">
                        Pantau Purchase Order (PO) masuk dari gudang pusat, kelola pasokan barang, dan konfirmasi pengiriman stok secara real-time.
                    </p>
                </div>

                <div style="display: flex; gap: 10px; align-items: center;">
                    <a href="/backend/suplier/pembelian/pembelian_barang.php" class="bento-btn bento-btn-lime">
                        <i class="fa-solid fa-truck-fast"></i> Buat Pasokan Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Bento Metrics Grid -->
        <div class="bento-grid-metrics">
            <div class="bento-subgrid-metrics">
                
                <!-- Metric 1: Total PO -->
                <div class="bento-card">
                    <div class="bento-card-label">Total Pesanan (PO) Masuk</div>
                    <div class="bento-card-value"><?= number_format($total_po) ?> <span style="font-size: 1rem; color: var(--c-sage);">Order</span></div>
                    <div class="bento-progress-track">
                        <div class="bento-progress-fill" style="width: <?= min(100, $total_po * 33) ?>%;"></div>
                    </div>
                    <div class="bento-card-sub" style="margin-top: 10px;">
                        <i class="fa-solid fa-file-invoice" style="color: var(--c-lime);"></i>
                        <span>Order pembelian dari gudang</span>
                    </div>
                </div>

                <!-- Metric 2: Total Revenue / Nilai Pasokan -->
                <div class="bento-card">
                    <div class="bento-card-label">Nilai Total Pasokan</div>
                    <div class="bento-card-value" style="font-size: 1.55rem; color: var(--c-mint);">
                        Rp <?= number_format($total_nilai_pasokan, 0, ',', '.') ?>
                    </div>
                    <div class="bento-progress-track">
                        <div class="bento-progress-fill" style="width: 85%;"></div>
                    </div>
                    <div class="bento-card-sub" style="margin-top: 10px;">
                        <i class="fa-solid fa-wallet" style="color: var(--c-mint);"></i>
                        <span>Akumulasi transaksi pasokan</span>
                    </div>
                </div>

                <!-- Metric 3: Total Unit Pasokan -->
                <div class="bento-card">
                    <div class="bento-card-label">Total Barang Tersalurkan</div>
                    <div class="bento-card-value"><?= number_format($total_unit_kirim) ?> <span style="font-size: 1rem; color: var(--c-sage);">Unit</span></div>
                    <div class="bento-progress-track">
                        <div class="bento-progress-fill" style="width: 70%;"></div>
                    </div>
                    <div class="bento-card-sub" style="margin-top: 10px;">
                        <i class="fa-solid fa-boxes-packing" style="color: var(--c-lime);"></i>
                        <span>Total unit barang diterima gudang</span>
                    </div>
                </div>

            </div>

            <!-- Metric 4: Highlight Card -->
            <div class="bento-card-highlight" style="background: linear-gradient(145deg, #163832 0%, #0b2b26 100%);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: var(--c-sage);">Kode Rekanan</div>
                        <div style="font-size: 1.35rem; font-weight: 800; color: #ffffff; font-family: var(--font-mono); margin-top: 4px;">
                            #<?= htmlspecialchars($id_supplier) ?>
                        </div>
                    </div>
                    <span class="bento-lime-badge">
                        <i class="fa-solid fa-shield-halved"></i> Mitra Resmi
                    </span>
                </div>

                <div style="margin: 16px 0; background: var(--c-forest-700); border: 1px solid var(--border-glass); border-radius: 12px; padding: 12px;">
                    <div style="font-size: 0.725rem; color: var(--c-sage);">Email Kontak</div>
                    <div style="font-size: 0.85rem; font-weight: 700; color: #ffffff; word-break: break-all; margin-top: 2px;">
                        <?= htmlspecialchars($sup_email) ?>
                    </div>
                    <div style="font-size: 0.725rem; color: var(--c-sage); margin-top: 8px;">Telepon: <strong style="color: var(--c-mint);"><?= htmlspecialchars($supplier['telepon_supplier'] ?? '-') ?></strong></div>
                </div>

                <a href="/backend/suplier/pembelian/transaksi_pembelian.php" class="bento-btn bento-btn-white" style="width: 100%; justify-content: center; font-size: 0.825rem; padding: 8px 16px;">
                    <i class="fa-solid fa-list-check"></i> Kelola Semua PO
                </a>
            </div>
        </div>

        <!-- ========================================================
             SIGNATURE BENTO SPLIT SECTION
             ======================================================== -->
        <div class="bento-split-grid" style="margin-bottom: 28px;">
            
            <!-- Left Side: Pale Mint Card (Daftar PO Masuk Terbaru) -->
            <div class="bento-card-light">
                <div class="bento-section-title">
                    <span>Pesanan Pembelian Masuk (PO)</span>
                    <span style="font-size: 0.725rem; font-weight: 700; background: var(--c-forest-900); color: var(--c-mint); padding: 4px 10px; border-radius: var(--radius-pill); font-family: var(--font-mono);">
                        <?= count($po_list) ?> PO
                    </span>
                </div>

                <?php if (!empty($po_list)): ?>
                    <div class="bento-light-list">
                        <?php foreach (array_slice($po_list, 0, 4) as $po): ?>
                            <div class="bento-light-item">
                                <div class="bento-light-item-left">
                                    <div class="bento-light-avatar" style="background: var(--c-forest-900); color: var(--c-lime);">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </div>
                                    <div>
                                        <div class="bento-light-name"><?= htmlspecialchars($po['no_pembelian']) ?></div>
                                        <div class="bento-light-meta"><?= htmlspecialchars($po['tanggal_pembelian']) ?> &bull; <?= (int)$po['total_barangall'] ?> unit pasokan</div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div class="bento-light-price">
                                        Rp <?= number_format((float)$po['total_hargaall'], 0, ',', '.') ?>
                                    </div>
                                    <a href="/backend/suplier/pembelian/detail_pembelian.php?no_pembelian=<?= urlencode($po['no_pembelian']) ?>" class="bento-status-pill bento-status-safe" style="font-size: 0.7rem; padding: 2px 8px; text-decoration: none;">
                                        Lihat Detail &rarr;
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 36px 20px; color: #64748b;">
                        <i class="fa-solid fa-inbox" style="font-size: 36px; margin-bottom: 12px; opacity: 0.4;"></i>
                        <div style="font-weight: 700; color: var(--c-forest-900);">Belum ada PO masuk</div>
                        <p style="font-size: 0.85rem; margin-top: 4px;">Pesanan pembelian dari admin gudang akan muncul di sini.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Side: Deep Forest Dark Card (Info Supplier & Gudang) -->
            <div class="bento-card-dark">
                <div class="bento-section-title">
                    <span>Profil Perusahaan &amp; Pabrik</span>
                    <span style="font-size: 0.75rem; color: var(--c-lime); font-family: var(--font-mono);">
                        <i class="fa-solid fa-building-circle-check"></i> Aktif
                    </span>
                </div>

                <div class="bento-dark-grid">
                    <div class="bento-metric-tile">
                        <div class="bento-tile-label">Nama Badan Usaha</div>
                        <div class="bento-tile-value" style="font-size: 1.05rem; color: #ffffff;">
                            <?= htmlspecialchars($nama_supplier) ?>
                        </div>
                    </div>

                    <div class="bento-metric-tile">
                        <div class="bento-tile-label">Status Verifikasi</div>
                        <div class="bento-tile-value" style="font-size: 1.05rem; color: var(--c-lime);">
                            Prioritas 1
                        </div>
                    </div>

                    <div class="bento-metric-tile" style="grid-column: span 2;">
                        <div class="bento-tile-label">Alamat Gudang / Pabrik Supplier</div>
                        <div style="color: var(--c-mint); font-size: 0.9rem; line-height: 1.5; margin-top: 4px;">
                            <i class="fa-solid fa-location-dot" style="color: var(--c-lime); margin-right: 6px;"></i>
                            <?= htmlspecialchars($supplier['alamat_supplier'] ?? 'Belum ada alamat tersimpan') ?>
                        </div>
                    </div>
                </div>

                <div style="background: var(--c-forest-700); border: 1px solid var(--border-glass); border-radius: var(--radius-bento-sm); padding: 16px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <span style="font-size: 0.8rem; font-weight: 700; color: #ffffff;">Integrasi Pasokan Gudang</span>
                        <span style="font-size: 0.725rem; color: var(--c-lime); font-weight: 700;">Terkoneksi</span>
                    </div>
                    <div style="font-size: 0.775rem; color: var(--c-sage);">
                        Setiap transaksi pasokan yang Anda konfirmasi akan langsung mengupdate stok fisik di master inventaris barang.
                    </div>
                </div>

                <a href="/backend/suplier/pembelian/pembelian_barang.php" class="bento-btn bento-btn-lime" style="width: 100%; justify-content: center;">
                    <i class="fa-solid fa-truck-ramp-box"></i> Kirim Pasokan ke Gudang
                </a>
            </div>

        </div>

        <!-- ========================================================
             TABEL SEMUA PURCHASE ORDERS (PO)
             ======================================================== -->
        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: #ffffff; font-size: 1.15rem; font-weight: 800; margin: 0;">Daftar Purchase Order (PO) Lengkap</h3>
                    <p style="color: var(--c-sage); font-size: 0.8rem; margin: 4px 0 0 0;">Riwayat pesanan pembelian stok dari gudang pusat</p>
                </div>
                <a href="/backend/suplier/pembelian/transaksi_pembelian.php" class="bento-btn bento-btn-dark" style="font-size: 0.8rem;">
                    <span>Lihat Halaman Transaksi</span> <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>No Pembelian</th>
                            <th>Tanggal PO</th>
                            <th>Jumlah Barang</th>
                            <th>Total Nilai PO</th>
                            <th>Status Pengiriman</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($po_list)): ?>
                            <?php foreach ($po_list as $po): ?>
                                <tr>
                                    <td style="font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                                        <?= htmlspecialchars($po['no_pembelian']) ?>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #ffffff;">
                                            <i class="fa-regular fa-calendar" style="color: var(--c-sage); margin-right: 6px;"></i>
                                            <?= htmlspecialchars($po['tanggal_pembelian']) ?>
                                        </div>
                                    </td>
                                    <td style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);">
                                        <?= (int)$po['total_barangall'] ?> Unit
                                    </td>
                                    <td>
                                        <div style="font-size: 1.05rem; font-weight: 800; color: #ffffff; font-family: var(--font-mono);">
                                            Rp <?= number_format((float)($po['total_hargaall'] ?? 0), 0, ',', '.') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="bento-status-pill bento-status-safe">
                                            <i class="fa-solid fa-check"></i> Terkonfirmasi
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="/backend/suplier/pembelian/detail_pembelian.php?no_pembelian=<?= urlencode($po['no_pembelian']) ?>" class="bento-btn bento-btn-dark bento-btn-sm" style="text-decoration: none;">
                                            <i class="fa-solid fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 48px 20px; color: var(--c-sage);">
                                    Belum ada pesanan pembelian baru untuk akun supplier ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <?php include_once __DIR__ . '/../../include/footer.php'; ?>

</body>
</html>