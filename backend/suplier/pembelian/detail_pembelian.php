<?php
require_once __DIR__ . '/../../../koneksi.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Supplier') {
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

$query = "SELECT * FROM detail_pembelian $where_sql ORDER BY id ASC";
$data = pg_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Pembelian - SIMTI Supplier</title>
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
                <a href="transaksi_pembelian.php" class="bento-back-btn" title="Kembali ke Daftar PO">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Detail Pembelian (PO)</h1>
            </div>

            <form method="GET" action="" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" name="no_pembelian" value="<?= htmlspecialchars($no_pembelian) ?>" placeholder="Filter No PO..." class="bento-input-control" style="width: 200px; padding: 8px 14px;">
                <button type="submit" class="bento-btn bento-btn-lime" style="padding: 8px 16px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
                <?php if ($no_pembelian || $kd_barang): ?>
                    <a href="detail_pembelian.php" class="bento-btn bento-btn-dark" style="padding: 8px 14px;">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: #ffffff; margin: 0; font-size: 1.15rem; font-weight: 700;">Rincian Item Pasokan</h3>
                    <p style="color: var(--c-sage); margin: 4px 0 0 0; font-size: 0.8rem;">
                        <?= $no_pembelian ? "Nomor PO: <strong>" . htmlspecialchars($no_pembelian) . "</strong>" : "Semua item rincian pasokan" ?>
                    </p>
                </div>

                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span><?= ($data ? pg_num_rows($data) : 0) ?> Item</span>
                </div>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>No PO</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data && pg_num_rows($data) > 0): ?>
                            <?php while ($row = pg_fetch_assoc($data)): ?>
                                <tr>
                                    <td>
                                        <span style="font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                                            <?= htmlspecialchars($row['no_pembelian']) ?>
                                        </span>
                                    </td>
                                    <td style="font-family: var(--font-mono); color: var(--c-mint);">
                                        <?= htmlspecialchars($row['kd_barang']) ?>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #ffffff;"><?= htmlspecialchars($row['nama_barang']) ?></div>
                                    </td>
                                    <td style="font-family: var(--font-mono); font-weight: 700; color: #ffffff;">
                                        <?= (int)$row['jumlah'] ?> Unit
                                    </td>
                                    <td style="font-family: var(--font-mono); color: var(--c-mint);">
                                        Rp <?= number_format((float)($row['harga_satuan'] ?? 0), 0, ',', '.') ?>
                                    </td>
                                    <td>
                                        <div style="font-size: 1rem; font-weight: 800; color: #ffffff; font-family: var(--font-mono);">
                                            Rp <?= number_format((float)($row['total_harga'] ?? 0), 0, ',', '.') ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 48px 20px; color: var(--c-sage);">
                                    Tidak ada rincian item pembelian ditemukan.
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