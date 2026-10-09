<?php 
include "koneksi.php"; 
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['tipe_user'])) {
    if ($_SESSION['tipe_user'] == 'Administrator') {
        header("Location: backend/admin/index_admin.php");
        exit();
    } elseif ($_SESSION['tipe_user'] == 'Supplier') {
        header("Location: backend/suplier/index_suplier.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk - SIMTI Inventory</title>
  
  <!-- Google Fonts & Font Awesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/clean-ui.css">

  <style>
    body {
      min-height: 100vh;
      background: radial-gradient(circle at 10% 20%, #0b2b26 0%, #051f20 90%) !important;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      color: var(--text-sage);
    }

    .auth-card-bento {
      width: 100%;
      max-width: 980px;
      background: var(--c-forest-800);
      border: 1px solid var(--border-glass);
      border-radius: var(--radius-bento);
      box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.7);
      display: flex;
      overflow: hidden;
      min-height: 580px;
    }

    /* Left Side: Editorial Showcase (Image 2 Colors) */
    .auth-brand-side {
      flex: 1;
      background: linear-gradient(160deg, #0b2b26 0%, #051f20 100%);
      padding: 48px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border-right: 1px solid var(--border-glass);
      position: relative;
    }

    .auth-brand-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 14px;
      background: rgba(218, 241, 222, 0.08);
      border: 1px solid var(--border-glass);
      border-radius: var(--radius-pill);
      font-size: 0.775rem;
      font-weight: 700;
      color: var(--c-mint);
      margin-bottom: 24px;
    }

    .auth-logo-title {
      font-size: 2rem;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.03em;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .auth-logo-sub {
      color: var(--text-sage);
      font-size: 0.95rem;
      line-height: 1.6;
      margin-bottom: 32px;
    }

    .auth-feature-box {
      background: rgba(22, 56, 50, 0.6);
      border: 1px solid var(--border-glass);
      border-radius: var(--radius-bento-sm);
      padding: 16px;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .auth-feature-box i {
      font-size: 1.25rem;
      color: var(--c-lime);
    }

    .auth-feature-text {
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--c-mint);
    }

    /* Right Side: High-Contrast Clean Form */
    .auth-form-side {
      flex: 1.1;
      background: #ffffff;
      padding: 48px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: var(--c-forest-900);
    }

    .auth-form-title {
      font-size: 1.75rem;
      font-weight: 800;
      color: var(--c-forest-900);
      letter-spacing: -0.03em;
      margin-bottom: 6px;
    }

    .auth-form-sub {
      color: #64748b;
      font-size: 0.9rem;
      margin-bottom: 28px;
    }

    .form-group-bento {
      margin-bottom: 18px;
    }

    .form-label-bento {
      display: block;
      font-size: 0.825rem;
      font-weight: 700;
      color: var(--c-forest-900);
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }

    .form-input-bento {
      width: 100%;
      padding: 13px 18px;
      border: 1.5px solid #cbd5e1;
      border-radius: var(--radius-bento-xs);
      font-size: 0.95rem;
      color: var(--c-forest-900);
      background: #f8fafc;
      font-family: var(--font-main);
      transition: all 0.2s ease;
    }

    .form-input-bento:focus {
      outline: none;
      background: #ffffff;
      border-color: #0b2b26;
      box-shadow: 0 0 0 4px rgba(11, 43, 38, 0.12);
    }

    .auth-submit-btn {
      width: 100%;
      padding: 14px;
      background: var(--c-forest-900);
      color: var(--c-lime);
      border: none;
      border-radius: var(--radius-pill);
      font-size: 0.95rem;
      font-weight: 800;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      transition: all 0.2s ease;
      margin-top: 10px;
      box-shadow: 0 8px 20px -4px rgba(5, 31, 32, 0.4);
    }

    .auth-submit-btn:hover {
      background: #0b2b26;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 12px 24px -4px rgba(5, 31, 32, 0.6);
    }

    .demo-pill-btn {
      padding: 6px 14px;
      border-radius: var(--radius-pill);
      background: #f1f5f9;
      border: 1px solid #e2e8f0;
      font-size: 0.775rem;
      font-weight: 700;
      color: var(--c-forest-900);
      cursor: pointer;
      transition: all 0.15s ease;
    }

    .demo-pill-btn:hover {
      background: var(--c-mint);
      border-color: var(--c-sage);
    }

    @media (max-width: 860px) {
      .auth-card-bento {
        flex-direction: column;
        max-width: 460px;
      }
      .auth-brand-side, .auth-form-side {
        padding: 32px 24px;
      }
    }
  </style>
</head>
<body>

  <div class="auth-card-bento">
    <!-- Left Showcase -->
    <div class="auth-brand-side">
      <div>
        <div class="auth-brand-badge">
          <span class="bento-pulse-dot"></span>
          <span>PostgreSQL Supabase Connected</span>
        </div>

        <div class="auth-logo-title">
          <div class="bento-brand-icon">
            <i class="fa-solid fa-boxes-stacked"></i>
          </div>
          <span>SIMTI</span>
        </div>

        <p class="auth-logo-sub">
          Sistem Pengelolaan Stok & Inventaris Gudang dengan Arsitektur Cloud Terintegrasi.
        </p>

        <div class="auth-feature-box">
          <i class="fa-solid fa-bolt"></i>
          <span class="auth-feature-text">Sinkronisasi Realtime Multi-Perangkat</span>
        </div>

        <div class="auth-feature-box">
          <i class="fa-solid fa-shield-halved"></i>
          <span class="auth-feature-text">Autentikasi Multi-Level (Admin, Supplier, Customer)</span>
        </div>

        <div class="auth-feature-box">
          <i class="fa-solid fa-cloud-arrow-up"></i>
          <span class="auth-feature-text">Vercel & Supabase Cloud Ready</span>
        </div>
      </div>

      <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
        <span>&copy; <?= date('Y') ?> SIMTI</span>
        <a href="index.php" style="color: var(--c-sage); text-decoration: none; font-weight: 600;">
          <i class="fa-solid fa-arrow-left"></i> Beranda
        </a>
      </div>
    </div>

    <!-- Right Form -->
    <div class="auth-form-side">
      <div class="auth-form-title">Selamat Datang</div>
      <p class="auth-form-sub">Masukkan kredensial akun untuk mengakses portal.</p>

      <form method="post" action="proses.php?action=login">
        <div class="form-group-bento">
          <label class="form-label-bento" for="username">Username / Email</label>
          <input type="text" id="username" name="username" class="form-input-bento" placeholder="admin atau email@mail.com" required autocomplete="username">
        </div>

        <div class="form-group-bento">
          <label class="form-label-bento" for="password">Password</label>
          <input type="password" id="password" name="password" class="form-input-bento" placeholder="••••••••" required autocomplete="current-password">
        </div>

        <button type="submit" class="auth-submit-btn">
          <span>Masuk ke Dashboard</span>
          <i class="fa-solid fa-arrow-right"></i>
        </button>
      </form>

      <!-- Quick Demo Account Fill -->
      <div style="margin-top: 28px; padding-top: 20px; border-top: 1px dashed #e2e8f0;">
        <div style="font-size: 0.725rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px;">
          Pilih Cepat Akun Demo:
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
          <button type="button" class="demo-pill-btn" onclick="fillDemo('admin', 'admin123')">
            <i class="fa-solid fa-user-shield"></i> Admin
          </button>
          <button type="button" class="demo-pill-btn" onclick="fillDemo('supplier@mail.com', 'sup123')">
            <i class="fa-solid fa-truck"></i> Supplier
          </button>
          <button type="button" class="demo-pill-btn" onclick="fillDemo('customer@mail.com', 'cust123')">
            <i class="fa-solid fa-user"></i> Customer
          </button>
        </div>
      </div>

      <div style="margin-top: 24px; text-align: center; font-size: 0.85rem; color: #64748b;">
        Belum memiliki akun? <a href="register.php" style="color: var(--c-forest-900); font-weight: 700; text-decoration: underline;">Daftar di sini</a>
      </div>
    </div>
  </div>

  <script>
    function fillDemo(u, p) {
      document.getElementById('username').value = u;
      document.getElementById('password').value = p;
      document.getElementById('username').focus();
    }
  </script>
</body>
</html>