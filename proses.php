<?php
include_once __DIR__ . "/koneksi.php";
session_start();

$action = $_GET['action'] ?? '';

/**
 * Render Modern Bespoke Bento Alert Screen
 * Eliminates browser default alert() and provides luxury visual feedback
 */
function render_bento_alert($type, $title, $message, $target_url, $badge = '', $role = '') {
    $is_success = ($type === 'success');
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?= htmlspecialchars($title) ?> - SIMTI</title>
      <link rel="icon" type="image/png" href="/assets/images/favicon.png">
      
      <!-- Fonts & Icons -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
      <link rel="stylesheet" href="/assets/css/clean-ui.css">

      <meta http-equiv="refresh" content="<?= $is_success ? '2' : '3' ?>;url=<?= htmlspecialchars($target_url) ?>">

      <style>
        body {
          min-height: 100vh;
          margin: 0;
          display: flex;
          align-items: center;
          justify-content: center;
          background: radial-gradient(circle at 50% 20%, #0d3831 0%, #051F20 80%) !important;
          padding: 20px;
          font-family: var(--font-main) !important;
        }

        .alert-bento-card {
          width: 100%;
          max-width: 480px;
          background: var(--c-forest-800);
          border: 1px solid var(--border-light);
          border-radius: var(--radius-bento);
          padding: 40px 32px;
          text-align: center;
          box-shadow: 0 35px 70px -15px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.05);
          position: relative;
          overflow: hidden;
          animation: bentoFadeUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes bentoFadeUp {
          from { opacity: 0; transform: translateY(16px) scale(0.97); }
          to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .alert-bento-card::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 3px;
          background: <?= $is_success ? 'linear-gradient(90deg, var(--c-lime) 0%, var(--c-mint) 100%)' : 'linear-gradient(90deg, #ef4444 0%, #f97316 100%)' ?>;
        }

        .alert-logo-box {
          width: 68px;
          height: 68px;
          margin: 0 auto 20px auto;
          border-radius: 20px;
          background: var(--c-forest-700);
          border: 1px solid var(--border-glass);
          display: flex;
          align-items: center;
          justify-content: center;
          box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        }

        .alert-logo-box img {
          width: 52px;
          height: 52px;
          border-radius: 14px;
          object-fit: contain;
        }

        .alert-badge {
          display: inline-flex;
          align-items: center;
          gap: 8px;
          padding: 5px 16px;
          border-radius: var(--radius-pill);
          font-size: 0.775rem;
          font-weight: 700;
          margin-bottom: 16px;
          <?= $is_success 
            ? 'background: rgba(163, 230, 53, 0.15); color: var(--c-lime); border: 1px solid rgba(163, 230, 53, 0.3);' 
            : 'background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.35);' ?>
        }

        .alert-title {
          font-size: 1.45rem;
          font-weight: 800;
          color: #ffffff;
          letter-spacing: -0.03em;
          margin: 0 0 10px 0;
        }

        .alert-message {
          font-size: 0.925rem;
          color: var(--c-sage);
          line-height: 1.55;
          margin: 0 0 28px 0;
        }

        .alert-progress {
          width: 100%;
          height: 5px;
          background: rgba(255, 255, 255, 0.08);
          border-radius: var(--radius-pill);
          overflow: hidden;
          margin-bottom: 24px;
        }

        .alert-progress-bar {
          height: 100%;
          width: 0%;
          background: <?= $is_success ? 'var(--c-lime)' : '#ef4444' ?>;
          border-radius: var(--radius-pill);
          transition: width <?= $is_success ? '1.2s' : '2s' ?> cubic-bezier(0.16, 1, 0.3, 1);
        }
      </style>
    </head>
    <body>

      <div class="alert-bento-card">
        <!-- Brand Logo -->
        <div class="alert-logo-box">
          <img src="/assets/images/logo.png" alt="SIMTI Logo">
        </div>

        <!-- Pill Status -->
        <div class="alert-badge">
          <?php if ($is_success): ?>
            <span class="bento-pulse-dot"></span>
            <span><?= htmlspecialchars($badge ?: 'Sukses') ?></span>
          <?php else: ?>
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span><?= htmlspecialchars($badge ?: 'Peringatan') ?></span>
          <?php endif; ?>
        </div>

        <!-- Title & Description -->
        <h2 class="alert-title"><?= htmlspecialchars($title) ?></h2>
        <p class="alert-message"><?= htmlspecialchars($message) ?></p>

        <!-- Animated Progress -->
        <div class="alert-progress">
          <div class="alert-progress-bar" id="pBar"></div>
        </div>

        <!-- Action Button -->
        <a href="<?= htmlspecialchars($target_url) ?>" class="bento-btn <?= $is_success ? 'bento-btn-lime' : 'bento-btn-dark' ?>" style="width: 100%; justify-content: center;">
          <span><?= $is_success ? 'Lanjutkan Sekarang' : 'Kembali' ?></span>
          <i class="fa-solid fa-arrow-right"></i>
        </a>
      </div>

      <script>
        // Start progress bar animation
        setTimeout(() => {
          const pb = document.getElementById('pBar');
          if (pb) pb.style.width = '100%';
        }, 50);

        // Auto redirect smoothly
        setTimeout(() => {
          window.location.href = <?= json_encode($target_url) ?>;
        }, <?= $is_success ? '1300' : '2200' ?>);
      </script>

    </body>
    </html>
    <?php
    exit();
}

if ($action == "login") {
    $username = pg_escape_string($conn, trim($_POST['username'] ?? ''));
    $password = pg_escape_string($conn, trim($_POST['password'] ?? ''));

    // 1. Cek user administrator
    $query1 = "SELECT * FROM \"user\" WHERE username = '$username' AND password = '$password'";
    $result1 = pg_query($conn, $query1);

    // 2. Cek customer
    $query2 = "SELECT * FROM tb_customer WHERE (email_customer = '$username' OR id_customer = '$username') AND pass_customer = '$password'";
    $result2 = pg_query($conn, $query2);

    // 3. Cek supplier
    $query3 = "SELECT * FROM tb_supplier WHERE (email_supplier = '$username' OR id_supplier = '$username') AND pass_supplier = '$password'";
    $result3 = pg_query($conn, $query3);

    if ($result1 && pg_num_rows($result1) > 0) {
        $user = pg_fetch_assoc($result1);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['tipe_user'] = "Administrator";

        render_bento_alert(
            'success',
            'Login Berhasil!',
            'Selamat datang, Administrator. Mengalihkan ke Dashboard Manajemen SIMTI...',
            'backend/admin/index_admin.php',
            'Akses Administrator Diberikan',
            'Administrator'
        );
    } elseif ($result2 && pg_num_rows($result2) > 0) {
        $user = pg_fetch_assoc($result2);
        $_SESSION['user_id'] = $user['id_customer'];
        $_SESSION['username'] = $user['email_customer'];
        $_SESSION['nama_customer'] = $user['nama_customer'];
        $_SESSION['tipe_user'] = "Customer";

        render_bento_alert(
            'success',
            'Selamat Datang, ' . ($user['nama_customer'] ?: 'Pelanggan') . '!',
            'Autentikasi akun berhasil. Mengalihkan ke Portal Pelanggan SIMTI...',
            'backend/customer/index_customer.php',
            'Portal Customer Aktif',
            'Customer'
        );
    } elseif ($result3 && pg_num_rows($result3) > 0) {
        $user = pg_fetch_assoc($result3);
        $_SESSION['user_id'] = $user['id_supplier'];
        $_SESSION['username'] = $user['email_supplier'];
        $_SESSION['nama_supplier'] = $user['nama_supplier'];
        $_SESSION['tipe_user'] = "Supplier";

        render_bento_alert(
            'success',
            'Selamat Datang, ' . ($user['nama_supplier'] ?: 'Mitra Supplier') . '!',
            'Autentikasi mitra berhasil. Mengalihkan ke Portal Pasokan Gudang...',
            'backend/suplier/index_suplier.php',
            'Portal Mitra Supplier',
            'Supplier'
        );
    } else {
        render_bento_alert(
            'error',
            'Kredensial Tidak Sesuai',
            'Username atau password yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            'login.php',
            'Autentikasi Gagal'
        );
    }
}
elseif ($action == "register") {
    $username = pg_escape_string($conn, trim($_POST['username'] ?? ''));
    $email = pg_escape_string($conn, trim($_POST['email'] ?? ''));
    $password = pg_escape_string($conn, trim($_POST['password'] ?? ''));
    $id_cust = "CST-" . time();

    $check = pg_query($conn, "SELECT * FROM tb_customer WHERE email_customer = '$email'");
    if ($check && pg_num_rows($check) > 0) {
        render_bento_alert(
            'error',
            'Email Telah Terdaftar',
            'Alamat email ' . htmlspecialchars($email) . ' sudah terdaftar dalam sistem. Silakan gunakan email lain atau langsung login.',
            'register.php',
            'Pendaftaran Ditolak'
        );
    } else {
        $ins = pg_query($conn, "INSERT INTO tb_customer (id_customer, nama_customer, email_customer, pass_customer) VALUES ('$id_cust', '$username', '$email', '$password')");
        if ($ins) {
            render_bento_alert(
                'success',
                'Registrasi Berhasil!',
                'Akun pelanggan Anda telah aktif. Silakan masuk dengan email dan password Anda.',
                'login.php',
                'Akun Dibuat'
            );
        } else {
            render_bento_alert(
                'error',
                'Registrasi Gagal',
                'Terjadi kesalahan saat memproses data pendaftaran. Silakan coba kembali.',
                'register.php',
                'Kesalahan Sistem'
            );
        }
    }
}
elseif ($action == "logout") {
    $role = $_SESSION['tipe_user'] ?? 'Pengguna';
    session_unset();
    session_destroy();

    render_bento_alert(
        'success',
        'Sesi Berhasil Diakhiri',
        'Anda telah keluar dengan aman dari akun ' . htmlspecialchars($role) . '. Terima kasih telah menggunakan SIMTI.',
        'index.php',
        'Logout Berhasil'
    );
} else {
    header("Location: index.php");
    exit();
}
