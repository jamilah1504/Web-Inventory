<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Administrator') {
    header("Location: /login.php");
    exit();
}
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

$sql = "SELECT * FROM pembayaran ORDER BY tanggal DESC, id_pembayaran DESC";
$result = pg_query($conn, $sql);

// Statistik Laporan Arus Transaksi
$total_transaksi_nominal = 0;
$res_sum = pg_query($conn, "SELECT COALESCE(SUM(total), 0) as s FROM pembayaran");
if ($res_sum && $rs = pg_fetch_assoc($res_sum)) {
    $total_transaksi_nominal = (float)$rs['s'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laporan Transaksi & Keuangan - SIMTI</title>
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
                <a href="/backend/admin/index_admin.php" class="bento-back-btn" title="Kembali ke Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Laporan Arus Transaksi</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <button onclick="window.print()" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-print"></i> Cetak Dokumen
                </button>
            </div>
        </div>

        <!-- Bento Metrics Mini Row -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 24px;">
            <div class="bento-card">
                <div class="bento-card-label">Akumulasi Nilai Transaksi</div>
                <div class="bento-card-value" style="color: var(--c-lime); font-size: 2rem;">
                    Rp <?= number_format($total_transaksi_nominal, 0, ',', '.') ?>
                </div>
                <div class="bento-card-sub">
                    <i class="fa-solid fa-chart-line" style="color: var(--c-lime);"></i>
                    <span>Tercatat di Supabase Ledger</span>
                </div>
            </div>

            <div class="bento-card">
                <div class="bento-card-label">Total Mutasi Keuangan</div>
                <div class="bento-card-value" style="font-size: 2rem;">
                    <?= ($result ? pg_num_rows($result) : 0) ?> <span style="font-size: 1rem; color: var(--text-sage);">Transaksi</span>
                </div>
                <div class="bento-card-sub">
                    <i class="fa-solid fa-shield-halved" style="color: #38bdf8;"></i>
                    <span>Status Transaksi Sukses 100%</span>
                </div>
            </div>
        </div>

        <!-- Bento Table Card -->
        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: var(--text-white); margin: 0; font-size: 1.15rem; font-weight: 700;">Jurnal Mutasi Pembayaran</h3>
                    <p style="color: var(--text-sage); margin: 4px 0 0 0; font-size: 0.8rem;">Rekapitulasi transaksi pembelian vendor dan penjualan pelanggan</p>
                </div>

                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span>Audit Ready</span>
                </div>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>ID Pembayaran</th>
                            <th>No. Transaksi</th>
                            <th>Jenis Transaksi</th>
                            <th>Metode Bayar</th>
                            <th>Status Transaksi</th>
                            <th>Tanggal</th>
                            <th style="text-align: right;">Total Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hasData = false;
                        if ($result && pg_num_rows($result) > 0) {
                            while ($row = pg_fetch_assoc($result)) {
                                $hasData = true;
                                ?>
                                <tr>
                                    <td>
                                        <span style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);">
                                            #<?= htmlspecialchars($row['id_pembayaran']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-family: var(--font-mono); color: #ffffff; font-weight: 600;">
                                            <?= htmlspecialchars($row['no_transaksi']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="bento-status-pill <?= (stripos($row['jenis_transaksi'], 'pembelian') !== false) ? 'bento-status-low' : 'bento-status-safe' ?>">
                                            <?= htmlspecialchars($row['jenis_transaksi']) ?>
                                        </span>
                                    </td>
                                    <td style="color: var(--text-sage); font-size: 0.85rem;">
                                        <i class="fa-solid fa-credit-card" style="margin-right: 6px;"></i>
                                        <?= htmlspecialchars($row['metode'] ?: 'Transfer') ?>
                                    </td>
                                    <td>
                                        <span class="bento-lime-badge" style="font-size: 0.725rem;">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <?= htmlspecialchars($row['status'] ?: 'Selesai') ?>
                                        </span>
                                    </td>
                                    <td style="color: var(--text-sage); font-size: 0.85rem;">
                                        <?= htmlspecialchars($row['tanggal']) ?>
                                    </td>
                                    <td style="text-align: right; font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                                        Rp <?= number_format($row['total'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        if (!$hasData) {
                            ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
                                    <i class="fa-solid fa-chart-pie" style="font-size: 2.2rem; display: block; margin-bottom: 12px; color: var(--c-forest-600);"></i>
                                    Tidak ada laporan transaksi yang tersimpan.
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