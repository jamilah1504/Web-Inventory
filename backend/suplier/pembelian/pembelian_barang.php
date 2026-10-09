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
$res_sup = pg_query($conn, "SELECT id_supplier, nama_supplier FROM tb_supplier WHERE email_supplier = '$sup_email'");
$supplier_info = ($res_sup && pg_num_rows($res_sup) > 0) ? pg_fetch_assoc($res_sup) : null;
$id_supplier = $supplier_info['id_supplier'] ?? $_SESSION['user_id'] ?? '';

// Auto generate No PO
$auto_po = "PO-" . date('Ymd') . "-" . rand(100, 999);

$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_pembelian = pg_escape_string($conn, trim($_POST['no_pembelian'] ?? ''));
    $tanggal_pembelian = pg_escape_string($conn, trim($_POST['tanggal_pembelian'] ?? date('Y-m-d')));
    $total_barangall = (int)($_POST['total_barangall'] ?? 0);
    $total_hargaall = (float)($_POST['total_hargaall'] ?? 0);

    if (empty($no_pembelian) || empty($tanggal_pembelian) || $total_barangall <= 0 || $total_hargaall <= 0) {
        $error_msg = "Harap isi semua informasi pasokan barang secara lengkap dan valid.";
    } else {
        $sql = "INSERT INTO tb_pembelian (no_pembelian, tanggal_pembelian, id_supplier, total_barangall, total_hargaall) 
                VALUES ('$no_pembelian', '$tanggal_pembelian', '$id_supplier', $total_barangall, $total_hargaall)";
        if (pg_query($conn, $sql)) {
            header("Location: transaksi_pembelian.php");
            exit();
        } else {
            $error_msg = "Gagal menyimpan pasokan: " . pg_last_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kirim Pasokan Barang - SIMTI Supplier</title>
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
                <a href="transaksi_pembelian.php" class="bento-back-btn" title="Kembali ke Daftar PO">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Kirim Pasokan Barang</h1>
            </div>
        </div>

        <div class="bento-form-card">
            <div class="bento-form-header">
                <div>
                    <h2>Formulir Pengiriman Pasokan Stok</h2>
                    <p>Catat pasokan barang yang akan dikirimkan ke gudang pusat</p>
                </div>
                <div class="bento-lime-badge">
                    <i class="fa-solid fa-truck"></i> Mitra #<?= htmlspecialchars($id_supplier) ?>
                </div>
            </div>

            <?php if ($error_msg): ?>
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #f87171; padding: 12px 18px; border-radius: var(--radius-bento-xs); margin-bottom: 20px; font-size: 0.875rem;">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i> <?= htmlspecialchars($error_msg) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="bento-form-grid">
                    
                    <div class="bento-input-group">
                        <label class="bento-input-label">Nomor PO / Surat Jalan</label>
                        <input type="text" name="no_pembelian" value="<?= htmlspecialchars($auto_po) ?>" required class="bento-input-control" style="font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Tanggal Pengiriman Pasokan</label>
                        <input type="date" name="tanggal_pembelian" value="<?= date('Y-m-d') ?>" required class="bento-input-control">
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Kode Rekanan Supplier</label>
                        <input type="text" value="<?= htmlspecialchars($id_supplier . ' - ' . ($supplier_info['nama_supplier'] ?? '')) ?>" readonly class="bento-input-control" style="opacity: 0.8; cursor: not-allowed; background: rgba(5, 31, 32, 0.5);">
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Total Unit Barang Pasokan</label>
                        <input type="number" name="total_barangall" min="1" placeholder="Contoh: 25" required class="bento-input-control">
                    </div>

                    <div class="bento-input-group bento-form-full">
                        <label class="bento-input-label">Total Nilai Tagihan (Rp)</label>
                        <input type="number" name="total_hargaall" min="1000" step="500" placeholder="Contoh: 5000000" required class="bento-input-control" style="font-family: var(--font-mono); font-weight: 700; font-size: 1.1rem; color: var(--c-mint);">
                    </div>

                </div>

                <div style="display: flex; gap: 14px; justify-content: flex-end; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border-glass);">
                    <a href="transaksi_pembelian.php" class="bento-btn bento-btn-dark">Batal</a>
                    <button type="submit" class="bento-btn bento-btn-lime">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Konfirmasi Pasokan
                    </button>
                </div>
            </form>
        </div>

    </main>

    <?php include_once __DIR__ . '/../../../include/footer.php'; ?>

</body>
</html>