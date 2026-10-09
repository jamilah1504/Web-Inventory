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

$sql = "SELECT * FROM tb_customer ORDER BY id_customer ASC";
$result = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Pelanggan - SIMTI</title>
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
                <h1 class="bento-title">Data Pelanggan</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="/backend/admin/penjualan/detail_penjualan.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-receipt"></i> Riwayat Penjualan
                </a>
                <a href="tambah_data_customer.php" class="bento-btn bento-btn-lime">
                    <i class="fa-solid fa-plus"></i> Tambah Pelanggan
                </a>
            </div>
        </div>

        <!-- Bento Table Card -->
        <div class="bento-table-card">
            <div class="bento-table-header">
                <div>
                    <h3 style="color: var(--text-white); margin: 0; font-size: 1.15rem; font-weight: 700;">Daftar Pelanggan Terdaftar</h3>
                    <p style="color: var(--text-sage); margin: 4px 0 0 0; font-size: 0.8rem;">Sinkronisasi kontak customer melalui PostgreSQL Supabase</p>
                </div>

                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span><?= ($result ? pg_num_rows($result) : 0) ?> Akun Terdaftar</span>
                </div>
            </div>

            <div class="bento-table-wrap">
                <table class="bento-table">
                    <thead>
                        <tr>
                            <th>ID Customer</th>
                            <th>Nama Customer</th>
                            <th>Jenis Kelamin</th>
                            <th>Kontak Telepon</th>
                            <th>Email Akun</th>
                            <th>Alamat Domisili</th>
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
                                            #<?= htmlspecialchars($row['id_customer']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; color: #ffffff;"><?= htmlspecialchars($row['nama_customer']) ?></div>
                                        <div style="font-size: 0.775rem; color: var(--text-sage);">Pelanggan Aktif</div>
                                    </td>
                                    <td>
                                        <span class="bento-status-pill <?= ($row['jenis_kelamin'] == 'Laki-laki') ? 'bento-status-safe' : 'bento-status-low' ?>">
                                            <?= htmlspecialchars($row['jenis_kelamin'] ?: 'Lainnya') ?>
                                        </span>
                                    </td>
                                    <td style="font-family: var(--font-mono); color: var(--text-sage);">
                                        <i class="fa-solid fa-phone" style="margin-right: 6px; font-size: 0.75rem;"></i>
                                        <?= htmlspecialchars($row['telepon_customer'] ?: '-') ?>
                                    </td>
                                    <td style="color: var(--text-sage);">
                                        <i class="fa-regular fa-envelope" style="margin-right: 6px; font-size: 0.75rem;"></i>
                                        <?= htmlspecialchars($row['email_customer'] ?: '-') ?>
                                    </td>
                                    <td style="color: var(--text-sage); font-size: 0.85rem; max-width: 240px;">
                                        <?= htmlspecialchars($row['alamat_customer'] ?: '-') ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <div style="display: inline-flex; gap: 8px;">
                                            <a href="edit_customer.php?id_customer=<?= urlencode($row['id_customer']) ?>" class="bento-btn bento-btn-sm bento-btn-warning" title="Edit Customer">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="hapus_customer.php?id_customer=<?= urlencode($row['id_customer']) ?>" class="bento-btn bento-btn-sm bento-btn-danger" onclick="return confirm('Hapus pelanggan ini?');" title="Hapus">
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
                                <td colspan="7" style="text-align: center; padding: 48px 20px; color: var(--text-muted);">
                                    <i class="fa-solid fa-users" style="font-size: 2.2rem; display: block; margin-bottom: 12px; color: var(--c-forest-600);"></i>
                                    Belum ada data pelanggan yang terdaftar.
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