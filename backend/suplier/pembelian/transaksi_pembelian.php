<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Supplier') {
    header("Location: /login.php");
    exit();
}
include_once __DIR__ . '/../../../koneksi.php';

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

$sup_email = $_SESSION['username'];
$res_sup = pg_query($conn, "SELECT id_supplier FROM tb_supplier WHERE email_supplier = '$sup_email'");
$id_supplier = ($res_sup && pg_num_rows($res_sup) > 0) ? pg_fetch_result($res_sup, 0, 0) : ($_SESSION['user_id'] ?? '');

$sql = "SELECT * FROM tb_pembelian WHERE id_supplier = '$id_supplier' ORDER BY no_pembelian DESC";
$result = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purchase Orders (PO) - SIMTI Supplier</title>
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/clean-ui.css">
</head>
<body>

    <?php include_once __DIR__ . '/../navbar.php'; ?>

    <main class="bento-container">
        
        <div class="bento-header-row">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="/backend/suplier/index_suplier.php" class="bento-back-btn" title="Kembali ke Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Pesanan Pembelian (PO)</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="pembelian_barang.php" class="bento-btn bento-btn-lime">
                    <i class="fa-solid fa-truck-fast"></i> Kirim Pasokan Baru
                </a>
            </div>
        </div>

        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: #ffffff; margin: 0; font-size: 1.15rem; font-weight: 700;">Daftar Purchase Order Masuk</h3>
                    <p style="color: var(--c-sage); margin: 4px 0 0 0; font-size: 0.8rem;">Pesanan stok yang ditugaskan kepada kode supplier #<?= htmlspecialchars($id_supplier) ?></p>
                </div>

                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span><?= ($result ? pg_num_rows($result) : 0) ?> Order Masuk</span>
                </div>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>No Pembelian (PO)</th>
                            <th>Tanggal Masuk</th>
                            <th>Kode Supplier</th>
                            <th>Total Unit Barang</th>
                            <th>Total Nilai Tagihan</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && pg_num_rows($result) > 0): ?>
                            <?php while ($row = pg_fetch_assoc($result)): ?>
                                <tr>
                                    <td>
                                        <span style="font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                                            <?= htmlspecialchars($row['no_pembelian']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; color: #ffffff;">
                                            <i class="fa-regular fa-calendar" style="color: var(--c-sage); margin-right: 6px;"></i>
                                            <?= htmlspecialchars($row['tanggal_pembelian']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-family: var(--font-mono); font-size: 0.8rem; padding: 2px 8px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint);">
                                            <?= htmlspecialchars($row['id_supplier']) ?>
                                        </span>
                                    </td>
                                    <td style="font-family: var(--font-mono); font-weight: 700; color: #ffffff;">
                                        <?= (int)$row['total_barangall'] ?> Unit
                                    </td>
                                    <td>
                                        <div style="font-size: 1.05rem; font-weight: 800; color: var(--c-mint); font-family: var(--font-mono);">
                                            Rp <?= number_format((float)($row['total_hargaall'] ?? 0), 0, ',', '.') ?>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 8px;">
                                            <a href="detail_pembelian.php?no_pembelian=<?= urlencode($row['no_pembelian']) ?>" class="bento-btn bento-btn-dark bento-btn-sm" title="Lihat Detail">
                                                <i class="fa-solid fa-eye"></i> Detail
                                            </a>
                                            <a href="edit_pembelian.php?no_pembelian=<?= urlencode($row['no_pembelian']) ?>" class="bento-btn bento-btn-warning bento-btn-sm" title="Edit">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 48px 20px; color: var(--c-sage);">
                                    Belum ada pesanan pembelian masuk untuk supplier ini.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <?php include_once __DIR__ . '/../../../include/footer.php'; ?>

</body>
</html>