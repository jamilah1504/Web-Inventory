<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Customer') {
    header("Location: /login.php");
    exit();
}
include_once __DIR__ . '/../../koneksi.php';

$cust_email = $_SESSION['username'];
$cust_res = pg_query($conn, "SELECT * FROM tb_customer WHERE email_customer = '$cust_email'");
$customer = ($cust_res && pg_num_rows($cust_res) > 0) ? pg_fetch_assoc($cust_res) : null;
$id_customer = $customer['id_customer'] ?? $_SESSION['user_id'] ?? '';

$sql = "SELECT * FROM tb_penjualan WHERE id_customer = '$id_customer' ORDER BY tanggal_penjualan DESC";
$result = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pesanan Saya - SIMTI Customer</title>
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/clean-ui.css">
</head>
<body>

    <?php include_once __DIR__ . '/navbar.php'; ?>

    <main class="bento-container">
        
        <div class="bento-header-row">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="index_customer.php" class="bento-back-btn" title="Kembali ke Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Pesanan &amp; Invoice Saya</h1>
            </div>

            <a href="katalog.php" class="bento-btn bento-btn-lime">
                <i class="fa-solid fa-plus"></i> Pesan Barang Baru
            </a>
        </div>

        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: #ffffff; margin: 0; font-size: 1.15rem; font-weight: 700;">Daftar Faktur Pembelian</h3>
                    <p style="color: var(--c-sage); margin: 4px 0 0 0; font-size: 0.8rem;">Riwayat pembelian tercatat atas akun <?= htmlspecialchars($customer['nama_customer'] ?? $cust_email) ?></p>
                </div>

                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span><?= ($result ? pg_num_rows($result) : 0) ?> Transaksi</span>
                </div>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>No Penjualan / Invoice</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total Barang</th>
                            <th>Total Pembayaran</th>
                            <th>Status Pengiriman</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && pg_num_rows($result) > 0): ?>
                            <?php while ($row = pg_fetch_assoc($result)): ?>
                                <tr>
                                    <td>
                                        <span style="font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                                            <?= htmlspecialchars($row['no_penjualan']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #ffffff;">
                                            <i class="fa-regular fa-calendar" style="color: var(--c-sage); margin-right: 6px;"></i>
                                            <?= htmlspecialchars($row['tanggal_penjualan']) ?>
                                        </div>
                                    </td>
                                    <td style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);">
                                        <?= (int)$row['total_barangall'] ?> Unit
                                    </td>
                                    <td>
                                        <div style="font-size: 1.05rem; font-weight: 800; color: #ffffff; font-family: var(--font-mono);">
                                            Rp <?= number_format((float)($row['total_hargaall'] ?? 0), 0, ',', '.') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="bento-status-pill bento-status-safe">
                                            <i class="fa-solid fa-truck-fast"></i> Selesai Dikirim
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 48px 20px; color: var(--c-sage);">
                                    <i class="fa-solid fa-receipt" style="font-size: 32px; opacity: 0.4; margin-bottom: 10px; display: block;"></i>
                                    Belum ada transaksi pembelian tercatat untuk akun Anda.
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
