<?php
require_once __DIR__ . '/../../../koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Administrator') {
    header("Location: /login.php");
    exit();
}

$kd_barang = isset($_GET['kd_barang']) ? trim($_GET['kd_barang']) : '';
$no_pembelian = isset($_GET['no_pembelian']) ? trim($_GET['no_pembelian']) : '';

$where = [];
if ($no_pembelian) {
    $esc_no = pg_escape_string($conn, $no_pembelian);
    $where[] = "no_pembelian = '$esc_no'";
}
if ($kd_barang) {
    $esc_kd = pg_escape_string($conn, $kd_barang);
    $where[] = "kd_barang = '$esc_kd'";
}
$where_sql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

$query = "SELECT * FROM detail_pembelian $where_sql ORDER BY id_detail_pembelian ASC";
$data = pg_query($conn, $query);

// Info Faktur Utama jika no_pembelian disediakan
$pembelian_info = null;
if ($no_pembelian) {
    $res_info = pg_query($conn, "SELECT p.*, s.nama_supplier FROM tb_pembelian p LEFT JOIN tb_supplier s ON p.id_supplier = s.id_supplier WHERE p.no_pembelian = '" . pg_escape_string($conn, $no_pembelian) . "'");
    if ($res_info && pg_num_rows($res_info) > 0) {
        $pembelian_info = pg_fetch_assoc($res_info);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Faktur Pembelian - SIMTI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/clean-ui.css">
</head>
<body>

    <!-- Top Capsule Navigation -->
    <?php include_once __DIR__ . '/../../../include/bento_header.php'; ?>

    <main class="bento-container">
        <!-- Header Row -->
        <div class="bento-header-row">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="transaksi_pembelian.php" class="bento-back-btn" title="Kembali ke Faktur Pembelian">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Rincian Pembelian</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="transaksi_pembelian.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-arrow-left"></i> Semua Faktur
                </a>
                <a href="pembelian_barang.php" class="bento-btn bento-btn-lime">
                    <i class="fa-solid fa-plus"></i> Buat PO Baru
                </a>
            </div>
        </div>

        <?php if ($pembelian_info): ?>
            <!-- Highlight Card Info Faktur (Image 1 Style) -->
            <div class="bento-card-dark" style="margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <span class="bento-lime-badge" style="margin-bottom: 8px;">Faktur Terverifikasi</span>
                        <div style="font-size: 1.75rem; font-weight: 800; color: #ffffff; font-family: var(--font-mono);">
                            #PO-<?= htmlspecialchars($pembelian_info['no_pembelian']) ?>
                        </div>
                        <div style="color: var(--text-sage); font-size: 0.85rem; margin-top: 4px;">
                            Tanggal Transaksi: <strong><?= htmlspecialchars($pembelian_info['tanggal_pembelian']) ?></strong> &bull; Supplier: <strong style="color: var(--c-mint);"><?= htmlspecialchars($pembelian_info['nama_supplier'] ?: $pembelian_info['id_supplier']) ?></strong>
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <div style="font-size: 0.8rem; color: var(--text-sage);">Total Nilai Order</div>
                        <div style="font-size: 1.85rem; font-weight: 800; color: var(--c-lime); font-family: var(--font-mono);">
                            Rp <?= number_format($pembelian_info['total_harga'] ?? $pembelian_info['total_hargaall'] ?? 0, 0, ',', '.') ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Table Card -->
        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: var(--text-white); margin: 0; font-size: 1.15rem; font-weight: 700;">Daftar Item Rincian Pengadaan</h3>
                    <p style="color: var(--text-sage); margin: 4px 0 0 0; font-size: 0.8rem;">Data rincian item per transaksi</p>
                </div>

                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span><?= ($data ? pg_num_rows($data) : 0) ?> Item Terdaftar</span>
                </div>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Pembelian</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th style="text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hasData = false;
                        if ($data && pg_num_rows($data) > 0) {
                            $no = 1;
                            while ($row = pg_fetch_assoc($data)) {
                                $hasData = true;
                                ?>
                                <tr>
                                    <td style="color: var(--text-sage);"><?= $no++ ?></td>
                                    <td>
                                        <span style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);">
                                            #PO-<?= htmlspecialchars($row['no_pembelian']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-family: var(--font-mono); color: #ffffff;">
                                            <?= htmlspecialchars($row['kd_barang']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #ffffff;">
                                            <?= htmlspecialchars($row['nama_barang']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="bento-status-pill bento-status-safe" style="font-family: var(--font-mono);">
                                            <?= (int)$row['jumlah'] ?> Unit
                                        </span>
                                    </td>
                                    <td style="font-family: var(--font-mono); color: var(--text-sage);">
                                        Rp <?= number_format($row['harga_satuan'] ?? 0, 0, ',', '.') ?>
                                    </td>
                                    <td style="text-align: right; font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                                        Rp <?= number_format($row['total_harga'] ?? 0, 0, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        if (!$hasData) {
                            ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
                                    <i class="fa-solid fa-folder-open" style="font-size: 2.2rem; display: block; margin-bottom: 12px; color: var(--c-forest-600);"></i>
                                    Tidak ada data rincian barang untuk filter ini.
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer style="text-align: center; padding: 24px; border-top: 1px solid var(--border-glass); font-size: 0.825rem; color: var(--text-muted);">
        &copy; <?= date('Y') ?> <strong>SIMTI Inventory</strong> &bull; Supabase PostgreSQL
    </footer>

</body>
</html>
<?php pg_close($conn); ?>