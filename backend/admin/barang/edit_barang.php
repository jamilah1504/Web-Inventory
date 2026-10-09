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

if (!isset($_GET['kd_barang']) || empty($_GET['kd_barang'])) {
    header("Location: data_barang.php");
    exit();
}

$kd_barang = pg_escape_string($conn, $_GET['kd_barang']);
$sql = "SELECT * FROM tb_barang WHERE kd_barang = '$kd_barang'";
$result = pg_query($conn, $sql);

if (!$result || !($row = pg_fetch_assoc($result))) {
    die("Data barang tidak ditemukan.");
}

$kategori_list = pg_query($conn, "SELECT * FROM kategori_barang ORDER BY nama_kategori ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_jenis = pg_escape_string($conn, trim($_POST['kode_jenis'] ?? ''));
    $nama_barang = pg_escape_string($conn, trim($_POST['nama_barang'] ?? ''));
    $stok = (int)($_POST['stok'] ?? 0);
    $harga_beli = (float)($_POST['harga_beli'] ?? 0);
    $harga_jual = (float)($_POST['harga_jual'] ?? 0);
    $gambar_produk = pg_escape_string($conn, trim($_POST['gambar_produk'] ?? 'default.jpg'));

    if (empty($nama_barang)) {
        $error = "Nama barang wajib diisi.";
    } else {
        $sql = "UPDATE tb_barang SET 
                kode_jenis = '$kode_jenis', 
                nama_barang = '$nama_barang', 
                stok = $stok, 
                harga_beli = $harga_beli, 
                harga_jual = $harga_jual, 
                gambar_produk = '$gambar_produk' 
                WHERE kd_barang = '$kd_barang'";
        if (pg_query($conn, $sql)) {
            header("Location: data_barang.php");
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
    <title>Edit Barang #<?= htmlspecialchars($kd_barang) ?> - SIMTI</title>
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
                <a href="data_barang.php" class="bento-back-btn" title="Kembali ke Katalog">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Perbarui Data Barang</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="data_barang.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-boxes-stacked"></i> Kembali ke Katalog
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bento-form-card">
            <div class="bento-form-header">
                <div>
                    <h2>Edit #<?= htmlspecialchars($kd_barang) ?> - <?= htmlspecialchars($row['nama_barang']) ?></h2>
                    <p>Perbarui rincian harga, jumlah stok fisik, dan informasi jenis barang</p>
                </div>
                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span>Editor Mode</span>
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
                        <label class="bento-input-label">Kode Barang (Permanen)</label>
                        <input type="text" name="kd_barang" class="bento-input-control" value="<?= htmlspecialchars($kd_barang) ?>" readonly style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint); opacity: 0.85;">
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Kategori / Kode Jenis</label>
                        <select name="kode_jenis" class="bento-input-control">
                            <option value="">-- Pilih Kategori --</option>
                            <?php if ($kategori_list): ?>
                                <?php while ($kat = pg_fetch_assoc($kategori_list)): ?>
                                    <option value="<?= htmlspecialchars($kat['id_kategori']) ?>" <?= ($row['kode_jenis'] == $kat['id_kategori']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($kat['nama_kategori']) ?> (<?= htmlspecialchars($kat['id_kategori']) ?>)
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="bento-input-group bento-form-full">
                        <label class="bento-input-label">Nama Barang / Produk</label>
                        <input type="text" name="nama_barang" class="bento-input-control" value="<?= htmlspecialchars($row['nama_barang']) ?>" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Harga Modal / Beli (Rp)</label>
                        <input type="number" step="any" name="harga_beli" class="bento-input-control" value="<?= htmlspecialchars($row['harga_beli']) ?>" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Harga Jual (Rp)</label>
                        <input type="number" step="any" name="harga_jual" class="bento-input-control" value="<?= htmlspecialchars($row['harga_jual']) ?>" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Jumlah Stok Fisik</label>
                        <input type="number" name="stok" class="bento-input-control" value="<?= (int)$row['stok'] ?>" min="0" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">File / URL Gambar</label>
                        <input type="text" name="gambar_produk" class="bento-input-control" value="<?= htmlspecialchars($row['gambar_produk'] ?? 'default.jpg') ?>">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--border-glass);">
                    <a href="data_barang.php" class="bento-btn bento-btn-dark">
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