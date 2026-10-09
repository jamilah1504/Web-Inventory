<?php 
include "koneksi.php"; 
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Akun - SIMTI Inventory</title>
  <link rel="icon" type="image/png" href="/assets/images/favicon.png">
  
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

    .auth-brand-side {
      flex: 1;
      background: linear-gradient(160deg, #0b2b26 0%, #051f20 100%);
      padding: 48px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border-right: 1px solid var(--border-glass);
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
          <span>Registrasi Akun Pelanggan</span>
        </div>

        <div class="auth-logo-title">
          <img src="/assets/images/logo.png" alt="SIMTI Logo" style="width: 44px; height: 44px; border-radius: 14px; object-fit: contain; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35);">
          <span>SIMTI</span>
        </div>

        <p class="auth-logo-sub">
          Daftarkan akun pelanggan baru untuk mengakses pesanan barang dan katalog stok gudang.
        </p>

        <div class="auth-feature-box">
          <i class="fa-solid fa-shield-check"></i>
          <span class="auth-feature-text">Data Tersimpan Aman di PostgreSQL Supabase</span>
        </div>

        <div class="auth-feature-box">
          <i class="fa-solid fa-receipt"></i>
          <span class="auth-feature-text">Faktur & Riwayat Transaksi Otomatis</span>
        </div>
      </div>

      <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
        <span>&copy; <?= date('Y') ?> SIMTI</span>
        <a href="login.php" style="color: var(--c-sage); text-decoration: none; font-weight: 600;">
          <i class="fa-solid fa-arrow-left"></i> Masuk Akun
        </a>
      </div>
    </div>

    <!-- Right Form -->
    <div class="auth-form-side">
      <div class="auth-form-title">Buat Akun Baru</div>
      <p class="auth-form-sub">Lengkapi data akun untuk registrasi pelanggan.</p>

      <form method="post" action="proses.php?action=register">
        <div class="form-group-bento">
          <label class="form-label-bento" for="username">Nama Lengkap</label>
          <input type="text" id="username" name="username" class="form-input-bento" placeholder="Nama lengkap Anda" required>
        </div>

        <div class="form-group-bento">
          <label class="form-label-bento" for="email">Email Aktif</label>
          <input type="email" id="email" name="email" class="form-input-bento" placeholder="nama@email.com" required>
        </div>

        <div class="form-group-bento">
          <label class="form-label-bento" for="password">Kata Sandi</label>
          <input type="password" id="password" name="password" class="form-input-bento" placeholder="••••••••" required>
        </div>

        <button type="submit" class="auth-submit-btn">
          <span>Daftar Akun</span>
          <i class="fa-solid fa-arrow-right"></i>
        </button>
      </form>

      <div style="margin-top: 24px; text-align: center; font-size: 0.85rem; color: #64748b;">
        Sudah memiliki akun? <a href="login.php" style="color: var(--c-forest-900); font-weight: 700; text-decoration: underline;">Masuk di sini</a>
      </div>
    </div>
  </div>

</body>
</html>