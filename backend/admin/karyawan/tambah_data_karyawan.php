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

$res_count = pg_query($conn, "SELECT COUNT(*) as c FROM tb_karyawan");
$next_num = ($res_count && $rc = pg_fetch_assoc($res_count)) ? ((int)$rc['c'] + 1) : 1;
$default_id = "KRY-" . str_pad($next_num, 3, "0", STR_PAD_LEFT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_karyawan = pg_escape_string($conn, trim($_POST['id_karyawan'] ?? ''));
    $nama_karyawan = pg_escape_string($conn, trim($_POST['nama_karyawan'] ?? ''));
    $jabatan = pg_escape_string($conn, trim($_POST['jabatan'] ?? 'Staff Gudang'));

    if (empty($id_karyawan) || empty($nama_karyawan)) {
        $error = "Semua field wajib diisi.";
    } else {
        $sql = "INSERT INTO tb_karyawan (id_karyawan, nama_karyawan, jabatan) VALUES ('$id_karyawan', '$nama_karyawan', '$jabatan')";
        if (pg_query($conn, $sql)) {
            header("Location: data_karyawan.php");
            exit();
        } else {
            $error = "Gagal menambah karyawan: " . pg_last_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Karyawan - SIMTI</title>
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
                <a href="data_karyawan.php" class="bento-back-btn" title="Kembali ke Daftar Karyawan">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Tambah Personel Staff</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="data_karyawan.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-user-group"></i> Tim Karyawan
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bento-form-card">
            <div class="bento-form-header">
                <div>
                    <h2>Pendaftaran Personel Baru</h2>
                    <p>Masukkan identitas serta jabatan personel operasional gudang</p>
                </div>
                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span>HR & Team</span>
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
                        <label class="bento-input-label">ID Karyawan</label>
                        <input type="text" name="id_karyawan" class="bento-input-control" value="<?= htmlspecialchars($default_id) ?>" style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Nama Lengkap</label>
                        <input type="text" name="nama_karyawan" class="bento-input-control" placeholder="Contoh: Danang Wijaya" required>
                    </div>

                    <div class="bento-input-group bento-form-full">
                        <label class="bento-input-label">Posisi / Jabatan</label>
                        <select name="jabatan" class="bento-input-control">
                            <option value="Manager Gudang">Manager Gudang</option>
                            <option value="Supervisor Logistik">Supervisor Logistik</option>
                            <option value="Staff Admin Gudang">Staff Admin Gudang</option>
                            <option value="Operator Lapangan">Operator Lapangan</option>
                            <option value="Quality Control">Quality Control</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--border-glass);">
                    <a href="data_karyawan.php" class="bento-btn bento-btn-dark">
                        Batal
                    </a>
                    <button type="submit" class="bento-btn bento-btn-lime">
                        <i class="fa-solid fa-user-plus"></i> Simpan Karyawan
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