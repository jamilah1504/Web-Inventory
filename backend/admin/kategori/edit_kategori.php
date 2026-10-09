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

if (!isset($_GET['id_kategori']) || empty($_GET['id_kategori'])) {
    header("Location: data_kategori.php");
    exit();
}

$id_kategori = pg_escape_string($conn, $_GET['id_kategori']);
$sql = "SELECT * FROM kategori_barang WHERE id_kategori = '$id_kategori'";
$result = pg_query($conn, $sql);

if (!$result || !($row = pg_fetch_assoc($result))) {
    die("Data kategori tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kategori = pg_escape_string($conn, trim($_POST['nama_kategori'] ?? ''));

    if (empty($nama_kategori)) {
        $error = "Nama kategori wajib diisi.";
    } else {
        $sql = "UPDATE kategori_barang SET nama_kategori = '$nama_kategori' WHERE id_kategori = '$id_kategori'";
        if (pg_query($conn, $sql)) {
            header("Location: data_kategori.php");
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
    <title>Edit Kategori #<?= htmlspecialchars($id_kategori) ?> - SIMTI</title>
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
                <a href="data_kategori.php" class="bento-back-btn" title="Kembali ke Daftar Kategori">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Edit Kategori Barang</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="data_kategori.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-tags"></i> Daftar Kategori
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bento-form-card">
            <div class="bento-form-header">
                <div>
                    <h2>Perbarui #<?= htmlspecialchars($id_kategori) ?></h2>
                    <p>Ubah nama atau label klasifikasi produk</p>
                </div>
                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span>Category Editor</span>
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
                        <label class="bento-input-label">ID Kategori (Tetap)</label>
                        <input type="text" class="bento-input-control" value="<?= htmlspecialchars($id_kategori) ?>" readonly style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint); opacity: 0.85;">
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="bento-input-control" value="<?= htmlspecialchars($row['nama_kategori']) ?>" required>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--border-glass);">
                    <a href="data_kategori.php" class="bento-btn bento-btn-dark">
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