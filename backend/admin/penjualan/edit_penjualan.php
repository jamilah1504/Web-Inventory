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

if (!isset($_GET['no_penjualan']) || empty($_GET['no_penjualan'])) {
    header("Location: detail_penjualan.php");
    exit();
}

$no_penjualan = pg_escape_string($conn, $_GET['no_penjualan']);
$sql = "SELECT * FROM tb_penjualan WHERE no_penjualan = '$no_penjualan'";
$result = pg_query($conn, $sql);

if (!$result || !($row = pg_fetch_assoc($result))) {
    die("Data penjualan tidak ditemukan.");
}

$customer_list = pg_query($conn, "SELECT * FROM tb_customer ORDER BY nama_customer ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal_penjualan = pg_escape_string($conn, $_POST['tanggal_penjualan'] ?? date('Y-m-d'));
    $id_customer = pg_escape_string($conn, $_POST['id_customer'] ?? '');
    $total_barangall = (int)($_POST['total_barangall'] ?? 0);
    $total_hargaall = (float)($_POST['total_hargaall'] ?? 0);

    if (empty($id_customer)) {
        $error = "Pelanggan wajib dipilih.";
    } else {
        $sql = "UPDATE tb_penjualan SET 
                tanggal_penjualan = '$tanggal_penjualan', 
                id_customer = '$id_customer', 
                total_barangall = $total_barangall, 
                total_hargaall = $total_hargaall, 
                total_barang = $total_barangall, 
                total_harga = $total_hargaall 
                WHERE no_penjualan = '$no_penjualan'";
        if (pg_query($conn, $sql)) {
            header("Location: detail_penjualan.php");
            exit();
        } else {
            $error = "Error: " . pg_last_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Penjualan #<?= htmlspecialchars($no_penjualan) ?> - SIMTI</title>
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
                <a href="detail_penjualan.php" class="bento-back-btn" title="Kembali ke Riwayat Penjualan">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Edit Faktur Penjualan</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="detail_penjualan.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-receipt"></i> Riwayat Penjualan
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bento-form-card">
            <div class="bento-form-header">
                <div>
                    <h2>Perbarui #INV-<?= htmlspecialchars($no_penjualan) ?></h2>
                    <p>Ubah detail invoice penjualan dan total transaksi</p>
                </div>
                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span>Invoice Editor</span>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div style="padding: 14px 18px; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); border-radius: var(--radius-bento-xs); color: #fca5a5; margin-bottom: 24px; font-size: 0.875rem;">
                    <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="bento-form-grid">
                    <div class="bento-input-group">
                        <label class="bento-input-label">Nomor Invoice (Tetap)</label>
                        <input type="text" class="bento-input-control" value="<?= htmlspecialchars($no_penjualan) ?>" readonly style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint); opacity: 0.85;">
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_penjualan" class="bento-input-control" value="<?= htmlspecialchars($row['tanggal_penjualan']) ?>" required>
                    </div>

                    <div class="bento-input-group bento-form-full">
                        <label class="bento-input-label">Pilih Pelanggan / Customer</label>
                        <select name="id_customer" class="bento-input-control" required>
                            <?php if ($customer_list): ?>
                                <?php while ($c = pg_fetch_assoc($customer_list)): ?>
                                    <option value="<?= htmlspecialchars($c['id_customer']) ?>" <?= ($row['id_customer'] == $c['id_customer']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c['nama_customer']) ?> (<?= htmlspecialchars($c['id_customer']) ?>)
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Total Unit Barang</label>
                        <input type="number" name="total_barangall" class="bento-input-control" value="<?= (int)($row['total_barangall'] ?: $row['total_barang']) ?>" min="1" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Total Nilai Penjualan (Rp)</label>
                        <input type="number" step="any" name="total_hargaall" class="bento-input-control" value="<?= htmlspecialchars($row['total_hargaall'] ?: $row['total_harga']) ?>" required>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--border-glass);">
                    <a href="detail_penjualan.php" class="bento-btn bento-btn-dark">
                        Batal
                    </a>
                    <button type="submit" class="bento-btn bento-btn-lime">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer style="text-align: center; padding: 24px; border-top: 1px solid var(--border-glass); font-size: 0.825rem; color: var(--text-muted);">
        &copy; <?= date('Y') ?> <strong>SIMTI Inventory</strong> &bull; Supabase PostgreSQL
    </footer>

</body>
</html>
<?php pg_close($conn); ?>