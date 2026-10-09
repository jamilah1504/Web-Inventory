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

$sql = "SELECT * FROM tb_barang ORDER BY kd_barang ASC";
$result = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Barang - SIMTI</title>
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
        <!-- Title & Action -->
        <div class="bento-header-row">
            <div style="display: flex; align-items: center; gap: 14px;">
                <a href="/backend/admin/index_admin.php" class="bento-back-btn" title="Kembali ke Dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Katalog Barang</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="data_stok.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-layer-group"></i> Cek Stok
                </a>
                <a href="tambah_data_barang.php" class="bento-btn bento-btn-lime">
                    <i class="fa-solid fa-plus"></i> Tambah Barang
                </a>
            </div>
        </div>

        <!-- Bento Table Card -->
        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: var(--text-white); margin: 0; font-size: 1.15rem; font-weight: 700;">Daftar Seluruh Barang</h3>
                    <p style="color: var(--text-sage); margin: 4px 0 0 0; font-size: 0.8rem;">Data sinkron secara otomatis dengan PostgreSQL Supabase</p>
                </div>

                <div class="bento-filter-pill">
                    <i class="fa-solid fa-database" style="color: var(--c-lime);"></i>
                    <span><?= ($result ? pg_num_rows($result) : 0) ?> Produk Terdaftar</span>
                </div>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok Fisik</th>
                            <th>Status</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hasData = false;
                        if ($result && pg_num_rows($result) > 0) {
                            while ($row = pg_fetch_assoc($result)) {
                                $hasData = true;
                                $stok = (int)($row['stok'] ?? 0);
                                ?>
                                <tr>
                                    <td>
                                        <span style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);">
                                            #<?= htmlspecialchars($row['kd_barang']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #ffffff;"><?= htmlspecialchars($row['nama_barang']) ?></div>
                                        <div style="font-size: 0.775rem; color: var(--text-sage);"><?= htmlspecialchars($row['kode_jenis'] ?? 'Umum') ?></div>
                                    </td>
                                    <td style="font-family: var(--font-mono); color: var(--text-sage);">
                                        Rp <?= number_format($row['harga_beli'] ?? 0, 0, ',', '.') ?>
                                    </td>
                                    <td style="font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                                        Rp <?= number_format($row['harga_jual'] ?? 0, 0, ',', '.') ?>
                                    </td>
                                    <td>
                                        <strong style="color: #ffffff; font-size: 1rem;"><?= $stok ?></strong> unit
                                    </td>
                                    <td>
                                        <?php if ($stok <= 10): ?>
                                            <span class="bento-status-pill bento-status-low">
                                                <i class="fa-solid fa-triangle-exclamation"></i> Menipis
                                            </span>
                                        <?php else: ?>
                                            <span class="bento-status-pill bento-status-safe">
                                                <i class="fa-solid fa-check"></i> Aman
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="edit_barang.php?kd_barang=<?= urlencode($row['kd_barang']) ?>" 
                                           class="bento-btn bento-btn-dark" style="padding: 6px 12px; font-size: 0.775rem;" title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <a href="hapus_barang.php?kd_barang=<?= urlencode($row['kd_barang']) ?>" 
                                           class="bento-btn" style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3); padding: 6px 12px; font-size: 0.775rem;" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');" title="Hapus Data">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        if (!$hasData) {
                            echo "<tr><td colspan='7' style='text-align: center; padding: 36px; color: var(--text-sage);'>Belum ada data barang tersimpan di database.</td></tr>";
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