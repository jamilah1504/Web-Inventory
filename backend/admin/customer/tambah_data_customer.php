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

$res_count = pg_query($conn, "SELECT COUNT(*) as c FROM tb_customer");
$next_num = ($res_count && $rc = pg_fetch_assoc($res_count)) ? ((int)$rc['c'] + 1) : 1;
$default_id = "CST-" . str_pad($next_num, 3, "0", STR_PAD_LEFT);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_customer = pg_escape_string($conn, trim($_POST['id_customer'] ?? ''));
    $nama_customer = pg_escape_string($conn, trim($_POST['nama_customer'] ?? ''));
    $jenis_kelamin = pg_escape_string($conn, trim($_POST['jenis_kelamin'] ?? 'Laki-laki'));
    $alamat_customer = pg_escape_string($conn, trim($_POST['alamat_customer'] ?? ''));
    $telepon_customer = pg_escape_string($conn, trim($_POST['telepon_customer'] ?? ''));
    $email_customer = pg_escape_string($conn, trim($_POST['email_customer'] ?? ''));
    $pass_customer = pg_escape_string($conn, trim($_POST['pass_customer'] ?? 'cust123'));

    if (empty($id_customer) || empty($nama_customer) || empty($email_customer)) {
        $error = "ID, Nama, dan Email customer wajib diisi.";
    } else {
        $sql = "INSERT INTO tb_customer (id_customer, nama_customer, jenis_kelamin, alamat_customer, telepon_customer, email_customer, pass_customer) 
                VALUES ('$id_customer', '$nama_customer', '$jenis_kelamin', '$alamat_customer', '$telepon_customer', '$email_customer', '$pass_customer')";
        if (pg_query($conn, $sql)) {
            header("Location: data_customer.php");
            exit();
        } else {
            $error = "Gagal menambah customer: " . pg_last_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Pelanggan Baru - SIMTI</title>
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
                <a href="data_customer.php" class="bento-back-btn" title="Kembali ke Daftar Pelanggan">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="bento-title">Pendaftaran Pelanggan</h1>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="data_customer.php" class="bento-btn bento-btn-dark">
                    <i class="fa-solid fa-users"></i> Daftar Pelanggan
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bento-form-card">
            <div class="bento-form-header">
                <div>
                    <h2>Registrasi Akun Customer</h2>
                    <p>Masukkan profil, kontak whatsapp, serta data domisili pelanggan baru</p>
                </div>
                <div class="bento-filter-pill">
                    <span class="bento-pulse-dot"></span>
                    <span>Customer Data</span>
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
                        <label class="bento-input-label">ID Customer</label>
                        <input type="text" name="id_customer" class="bento-input-control" value="<?= htmlspecialchars($default_id) ?>" style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Nama Lengkap</label>
                        <input type="text" name="nama_customer" class="bento-input-control" placeholder="Contoh: Rian Pratama" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="bento-input-control">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Nomor WhatsApp / HP</label>
                        <input type="text" name="telepon_customer" class="bento-input-control" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Email Pelanggan</label>
                        <input type="email" name="email_customer" class="bento-input-control" placeholder="customer@mail.com" required>
                    </div>

                    <div class="bento-input-group">
                        <label class="bento-input-label">Password Akun (Default: cust123)</label>
                        <input type="text" name="pass_customer" class="bento-input-control" value="cust123">
                    </div>

                    <div class="bento-input-group bento-form-full">
                        <label class="bento-input-label">Alamat Lengkap</label>
                        <textarea name="alamat_customer" class="bento-input-control" placeholder="Jl. Contoh No. 123, Kota..."></textarea>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--border-glass);">
                    <a href="data_customer.php" class="bento-btn bento-btn-dark">
                        Batal
                    </a>
                    <button type="submit" class="bento-btn bento-btn-lime">
                        <i class="fa-solid fa-plus"></i> Simpan Pelanggan
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