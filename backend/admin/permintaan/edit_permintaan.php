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

if (!isset($_GET['id_keluar']) || empty($_GET['id_keluar'])) {
    header("Location: daftar_permintaan.php");
    exit();
}

$id_keluar = pg_escape_string($conn, $_GET['id_keluar']);
$sql = "SELECT COALESCE(id_keluar, CAST(id AS VARCHAR)) AS id_keluar, id, kd_barang, jumlah, tanggal, alasan FROM stok_keluar WHERE id_keluar = '$id_keluar' OR CAST(id AS VARCHAR) = '$id_keluar'";
$result = pg_query($conn, $sql);

if (!$result || !($row = pg_fetch_assoc($result))) {
    die("Data permintaan tidak ditemukan.");
}

$barang_options = pg_query($conn, "SELECT kd_barang, nama_barang, stok FROM tb_barang ORDER BY nama_barang ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kd_barang = pg_escape_string($conn, $_POST['kd_barang'] ?? '');
    $jumlah = (int)($_POST['jumlah'] ?? 0);
    $tanggal = pg_escape_string($conn, $_POST['tanggal'] ?? date('Y-m-d'));
    $alasan = pg_escape_string($conn, $_POST['alasan'] ?? '');

    if (empty($kd_barang) || $jumlah <= 0 || empty($tanggal)) {
        $error = "Semua field wajib diisi.";
    } else {
        $sql = "UPDATE stok_keluar SET kd_barang = '$kd_barang', jumlah = $jumlah, tanggal = '$tanggal', alasan = '$alasan' WHERE id_keluar = '$id_keluar' OR CAST(id AS VARCHAR) = '$id_keluar'";
        if (pg_query($conn, $sql)) {
            header("Location: daftar_permintaan.php");
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
    <title>Edit Permintaan #REQ-<?= htmlspecialchars($id_keluar) ?> - SIMTI</title>
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
                <a href="daftar_permintaan.php" class="bento-back-btn" title="Kembali ke Daftar Permintaan">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Edit Permintaan Barang</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="daftar_permintaan.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Permintaan
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bento-form-card">
            <div class="bento-form-header">
                <div>
                    <h2>Perbarui #REQ-<?= htmlspecialchars($id_keluar) ?></h2>
                    <p>Ubah rincian unit diminta, tanggal, atau keterangan keperluan</p>
                </div>
                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span>Requisition Editor</span>
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
                        <label class="bento-input-label">Pilih Barang</label>
                        <select name="kd_barang" class="bento-input-control" required>
                            <?php if ($barang_options): ?>
                                <?php while ($bo = pg_fetch_assoc($barang_options)): ?>
                                    <option value="<?= htmlspecialchars($bo['kd_barang']) ?>" <?= ($row['kd_barang'] == $bo['kd_barang']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($bo['kd_barang']) ?> - <?= htmlspecialchars($bo['nama_barang']) ?> (Stok: <?= (int)$bo['stok'] ?>)
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Jumlah Unit Diminta</label>
                        <input type="number" name="jumlah" class="bento-input-control" value="<?= (int)$row['jumlah'] ?>" min="1" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Tanggal Permintaan</label>
                        <input type="date" name="tanggal" class="bento-input-control" value="<?= htmlspecialchars($row['tanggal']) ?>" required>
                    </div>

                    <div class="bento-input-group bento-form-full">
                        <label class="bento-input-label">Keterangan / Keperluan</label>
                        <textarea name="alasan" class="bento-input-control" required><?= htmlspecialchars($row['alasan']) ?></textarea>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--border-glass);">
                    <a href="daftar_permintaan.php" class="bento-btn bento-btn-dark">
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