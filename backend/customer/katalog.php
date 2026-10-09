<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Customer') {
    header("Location: /login.php");
    exit();
}
include_once __DIR__ . '/../../koneksi.php';

$search = $_GET['search'] ?? '';
$search_clean = pg_escape_string($conn, $search);

$sql = "SELECT b.*, COALESCE(k.nama_kategori, b.kode_jenis, 'Umum') as kategori 
        FROM tb_barang b 
        LEFT JOIN kategori_barang k ON b.kode_jenis = k.id_kategori ";
if (!empty($search)) {
    $sql .= " WHERE b.nama_barang ILIKE '%$search_clean%' OR b.kd_barang ILIKE '%$search_clean%' OR k.nama_kategori ILIKE '%$search_clean%'";
}
$sql .= " ORDER BY b.kd_barang ASC";
$res = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Katalog Produk - SIMTI Customer</title>
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
                <h1 class="bento-title">Katalog Produk</h1>
            </div>

            <form method="GET" action="" style="display: flex; gap: 10px; align-items: center;">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari nama barang atau SKU..." class="bento-input-control" style="width: 260px; padding: 8px 16px;">
                <button type="submit" class="bento-btn bento-btn-lime" style="padding: 8px 18px;">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                <?php if (!empty($search)): ?>
                    <a href="katalog.php" class="bento-btn bento-btn-dark" style="padding: 8px 14px;">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Bento Grid Catalog Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <?php if ($res && pg_num_rows($res) > 0): ?>
                <?php while ($item = pg_fetch_assoc($res)): ?>
                    <div class="bento-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                <span style="font-family: var(--font-mono); font-size: 0.775rem; color: var(--c-lime); font-weight: 700;">
                                    #<?= htmlspecialchars($item['kd_barang']) ?>
                                </span>
                                <span style="font-size: 0.725rem; padding: 2px 10px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint);">
                                    <?= htmlspecialchars($item['kategori']) ?>
                                </span>
                            </div>

                            <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--c-forest-700); display: flex; align-items: center; justify-content: center; color: var(--c-mint); font-size: 20px; margin-bottom: 14px;">
                                <i class="fa-solid fa-box"></i>
                            </div>

                            <h3 style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin: 0 0 8px 0; line-height: 1.3;">
                                <?= htmlspecialchars($item['nama_barang']) ?>
                            </h3>

                            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-top: 14px;">
                                <div>
                                    <div style="font-size: 0.725rem; color: var(--c-sage);">Harga Satuan</div>
                                    <div style="font-size: 1.2rem; font-weight: 800; color: var(--c-mint); font-family: var(--font-mono);">
                                        Rp <?= number_format((float)$item['harga_jual'], 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.725rem; color: var(--c-sage);">Tersedia</div>
                                    <div style="font-weight: 700; color: #ffffff;">
                                        <?= number_format((int)$item['stok']) ?> Unit
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 20px; padding-top: 14px; border-top: 1px solid var(--border-glass);">
                            <?php if ((int)$item['stok'] > 0): ?>
                                <span class="bento-status-pill bento-status-safe" style="width: 100%; justify-content: center; padding: 8px;">
                                    <i class="fa-solid fa-circle-check"></i> Siap Dipesan di Gudang
                                </span>
                            <?php else: ?>
                                <span class="bento-status-pill bento-status-low" style="width: 100%; justify-content: center; padding: 8px;">
                                    <i class="fa-solid fa-circle-xmark"></i> Stok Kosong
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="bento-card" style="grid-column: 1 / -1; text-align: center; padding: 48px;">
                    <i class="fa-solid fa-box-open" style="font-size: 40px; color: var(--c-sage); opacity: 0.5; margin-bottom: 14px;"></i>
                    <h3 style="color: #ffffff; margin: 0 0 6px 0;">Tidak ada produk ditemukan</h3>
                    <p style="color: var(--c-sage); margin: 0;">Silakan coba kata kunci pencarian lainnya.</p>
                </div>
            <?php endif; ?>
        </div>

    </main>

    <?php include_once __DIR__ . '/../../include/footer.php'; ?>

</body>
</html>
