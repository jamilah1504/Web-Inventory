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

$sql = "SELECT k.*, COUNT(b.kd_barang) as total_produk 
        FROM kategori_barang k 
        LEFT JOIN tb_barang b ON k.id_kategori = b.kode_jenis 
        GROUP BY k.id_kategori, k.nama_kategori 
        ORDER BY k.id_kategori ASC";
$result = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kategori Barang - SIMTI</title>
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
                <h1 class="bento-title">Kategori Barang</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="/backend/admin/barang/data_barang.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-boxes-stacked"></i> Master Barang
                </a>
                <a href="tambah_data_kategori.php" class="bento-btn bento-btn-lime">
                    <i class="fa-solid fa-plus"></i> Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Bento Table Card -->
        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: var(--text-white); margin: 0; font-size: 1.15rem; font-weight: 700;">Klasifikasi & Kelompok Produk</h3>
                    <p style="color: var(--text-sage); margin: 4px 0 0 0; font-size: 0.8rem;">Struktur pengelompokan item inventaris di database</p>
                </div>

                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span><?= ($result ? pg_num_rows($result) : 0) ?> Klasifikasi</span>
                </div>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Total Barang Terkait</th>
                            <th style="text-align: right;">Aksi</th>
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
                                            #<?= htmlspecialchars($row['id_kategori']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #ffffff;">
                                            <?= htmlspecialchars($row['nama_kategori']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="bento-status-pill bento-status-safe" style="font-family: var(--font-mono);">
                                            <?= (int)$row['total_produk'] ?> SKU Produk
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 8px;">
                                            <a href="edit_kategori.php?id_kategori=<?= urlencode($row['id_kategori']) ?>" class="bento-btn bento-btn-sm bento-btn-warning" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="hapus_kategori.php?id_kategori=<?= urlencode($row['id_kategori']) ?>" class="bento-btn bento-btn-sm bento-btn-danger" onclick="return confirm('Hapus kategori ini?');" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        if (!$hasData) {
                            ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
                                    <i class="fa-solid fa-tags" style="font-size: 2.2rem; display: block; margin-bottom: 12px; color: var(--c-forest-600);"></i>
                                    Belum ada kategori yang dibuat.
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