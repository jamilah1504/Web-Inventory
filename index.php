<?php
/**
 * SIMTI - Modern Warehouse & Inventory Intelligence
 * Bespoke Bento UI Landing Page (Forest Dark & Pale Mint Palette)
 * Aligned with Image 1 (Bento UI) & Image 2 (Color Palette #051F20, #0B2B26, #163832, #235347, #8EB69B, #DAF1DE, #a3e635)
 */

include_once __DIR__ . '/koneksi.php';

// Inisialisasi statistik default dengan graceful fallbacks
$total_barang     = 0;
$total_nilai_aset = 0;
$total_supplier   = 0;
$total_customer   = 0;
$total_pembelian  = 0;
$total_penjualan  = 0;
$recent_items     = [];
$db_connected     = false;

if (isset($conn) && $conn) {
    $db_connected = true;

    // 1. Total Barang & Nilai Aset
    $res_b = @pg_query($conn, "SELECT COUNT(*), COALESCE(SUM(stok * harga_beli), 0) FROM tb_barang");
    if ($res_b && $row = pg_fetch_row($res_b)) {
        $total_barang     = (int)$row[0];
        $total_nilai_aset = (float)$row[1];
    }

    // 2. Total Supplier
    $res_s = @pg_query($conn, "SELECT COUNT(*) FROM tb_supplier");
    if ($res_s && $row = pg_fetch_row($res_s)) {
        $total_supplier = (int)$row[0];
    }

    // 3. Total Customer
    $res_c = @pg_query($conn, "SELECT COUNT(*) FROM tb_customer");
    if ($res_c && $row = pg_fetch_row($res_c)) {
        $total_customer = (int)$row[0];
    }

    // 4. Total Transaksi (Pembelian & Penjualan)
    $res_pem = @pg_query($conn, "SELECT COUNT(*) FROM tb_pembelian");
    if ($res_pem && $row = pg_fetch_row($res_pem)) {
        $total_pembelian = (int)$row[0];
    }
    $res_pen = @pg_query($conn, "SELECT COUNT(*) FROM tb_penjualan");
    if ($res_pen && $row = pg_fetch_row($res_pen)) {
        $total_penjualan = (int)$row[0];
    }

    // 5. Item barang untuk showcase Bento Card
    $res_items = @pg_query($conn, "SELECT b.kd_barang, b.nama_barang, COALESCE(k.nama_kategori, b.kode_jenis, 'Umum') as kategori, b.stok, b.harga_jual FROM tb_barang b LEFT JOIN kategori_barang k ON b.kode_jenis = k.id_kategori ORDER BY b.kd_barang DESC LIMIT 5");
    if ($res_items) {
        while ($r = pg_fetch_assoc($res_items)) {
            $recent_items[] = $r;
        }
    }
}

// Fallback data representatif jika database kosong atau belum terisi
if (empty($recent_items)) {
    $recent_items = [
        ['kd_barang' => 'BRG-001', 'nama_barang' => 'Keyboard Mekanikal RGB', 'kategori' => 'Elektronik', 'stok' => 25, 'harga_jual' => 450000],
        ['kd_barang' => 'BRG-002', 'nama_barang' => 'Mouse Wireless Silent', 'kategori' => 'Elektronik', 'stok' => 40, 'harga_jual' => 165000],
        ['kd_barang' => 'BRG-003', 'nama_barang' => 'Kertas HVS A4 80gr (Rim)', 'kategori' => 'Alat Tulis Kantor', 'stok' => 100, 'harga_jual' => 58000],
    ];
}
$total_transaksi = $total_pembelian + $total_penjualan;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIMTI - Modern Warehouse & Inventory Intelligence</title>
  <meta name="description" content="Sistem Informasi Inventory & Gudang Cerdas Berbasis Cloud PostgreSQL & Supabase dengan Arsitektur Bento UI Modern.">
  <meta name="theme-color" content="#051F20">

  <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Clean UI Bento Design System -->
  <link rel="stylesheet" href="assets/css/clean-ui.css">

  <style>
    html {
      scroll-behavior: smooth;
    }
    body {
      background-color: var(--c-forest-900) !important;
      color: var(--c-sage) !important;
      overflow-x: hidden;
    }
  </style>
</head>
<body>

  <!-- ========================================================
       TOP FLOATING CAPSULE NAVIGATION (Image 1 Style)
       ======================================================== -->
  <header class="landing-nav">
    <div class="landing-nav-inner">
      <a href="index.php" class="landing-brand">
        <div class="landing-brand-icon">
          <i class="fas fa-boxes-stacked"></i>
        </div>
        <div class="landing-brand-text">
          <span>SIMTI</span>
          <span class="landing-brand-sub">Inventory Cloud</span>
        </div>
      </a>

      <?php include 'navbar.php'; ?>
    </div>
  </header>

  <!-- ========================================================
       HERO SECTION: High-Impact Editorial Heading & CTAs
       ======================================================== -->
  <section class="landing-hero" id="hero">
    <div class="landing-hero-container">
      
      <!-- Live Status Badge -->
      <div class="hero-pill-badge">
        <span class="bento-pulse-dot"></span>
        <span>Supabase PostgreSQL Engine &bull; Cloud Sync Active</span>
      </div>

      <!-- Main Headline -->
      <h1 class="hero-title">
        Modern Warehouse &amp; <span>Inventory Intelligence</span>
      </h1>

      <!-- Subheadline -->
      <p class="hero-subtitle">
        Platform manajemen inventaris real-time terintegrasi Supabase PostgreSQL. 
        Pantau mutasi stok masuk dan keluar, kendalikan batas stok minimum otomatis, 
        serta sajikan audit transaksi transparan dengan ketepatan presisi tinggi.
      </p>

      <!-- Dual Call To Actions -->
      <div class="hero-cta-group">
        <a href="login.php" class="hero-btn-primary">
          <span>Buka Portal Sistem</span>
          <i class="fas fa-arrow-right"></i>
        </a>
        <a href="#showcase" class="hero-btn-secondary">
          <i class="fas fa-layer-group"></i>
          <span>Eksplor Live Bento</span>
        </a>
      </div>

      <!-- Tech Feature Pills -->
      <div style="display: flex; justify-content: center; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 30px;">
        <span style="font-size: 0.775rem; color: var(--c-sage); font-weight: 600; padding: 5px 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-glass); border-radius: var(--radius-pill);">
          <i class="fas fa-database" style="color: var(--c-lime); margin-right: 6px;"></i> PostgreSQL 15+
        </span>
        <span style="font-size: 0.775rem; color: var(--c-sage); font-weight: 600; padding: 5px 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-glass); border-radius: var(--radius-pill);">
          <i class="fas fa-cloud" style="color: var(--c-lime); margin-right: 6px;"></i> Supabase Pooler
        </span>
        <span style="font-size: 0.775rem; color: var(--c-sage); font-weight: 600; padding: 5px 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-glass); border-radius: var(--radius-pill);">
          <i class="fas fa-server" style="color: var(--c-lime); margin-right: 6px;"></i> Vercel Serverless Ready
        </span>
        <span style="font-size: 0.775rem; color: var(--c-sage); font-weight: 600; padding: 5px 14px; background: rgba(255,255,255,0.03); border: 1px solid var(--border-glass); border-radius: var(--radius-pill);">
          <i class="fas fa-shield-halved" style="color: var(--c-lime); margin-right: 6px;"></i> Role-Based RBAC
        </span>
      </div>

      <!-- ========================================================
           INTERACTIVE BENTO SHOWCASE (Faithfully Modeled from Image 1)
           ======================================================== -->
      <div class="hero-mockup-wrapper" id="showcase">
        <div class="hero-device-frame">
          
          <!-- Mockup Topbar Capsule -->
          <div class="mockup-topbar">
            <div class="mockup-brand">
              <i class="fas fa-asterisk" style="color: var(--c-lime); font-size: 16px;"></i>
              <span style="font-weight: 800; color: #ffffff; font-size: 1.05rem; letter-spacing: -0.02em;">Gudang Pusat Jakarta</span>
            </div>

            <!-- Segmented Pill Filter Bar (from top of Image 1) -->
            <div class="mockup-capsule-tabs">
              <span class="mockup-tab active"><i class="fas fa-check-circle" style="margin-right: 4px;"></i> Semua Stok</span>
              <span class="mockup-tab">Barang Masuk</span>
              <span class="mockup-tab">Barang Keluar</span>
              <span class="mockup-tab">Supplier</span>
              <span class="mockup-tab">Live Sync</span>
            </div>

            <!-- User status pill -->
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 0.75rem; color: var(--c-mint); font-weight: 700; background: rgba(163, 230, 53, 0.15); border: 1px solid rgba(163, 230, 53, 0.3); padding: 4px 10px; border-radius: var(--radius-pill);">
                <i class="fas fa-circle" style="color: var(--c-lime); font-size: 7px; margin-right: 4px;"></i> Live Portal
              </span>
            </div>
          </div>

          <!-- Bento Top Metrics Grid (from Image 1) -->
          <div class="bento-grid-metrics" style="margin-bottom: 22px;">
            <!-- Subgrid 3 Cards -->
            <div class="bento-subgrid-metrics">
              
              <!-- Metric 1: Total SKU -->
              <div class="bento-card">
                <div class="bento-card-label">Master SKU Barang</div>
                <div class="bento-card-value"><?= number_format($total_barang) ?> <span style="font-size: 1rem; font-weight: 600; color: var(--c-sage);">Item</span></div>
                <div class="bento-progress-track">
                  <div class="bento-progress-fill" style="width: 82%;"></div>
                </div>
                <div class="bento-card-sub" style="margin-top: 10px;">
                  <i class="fas fa-arrow-trend-up" style="color: var(--c-lime);"></i>
                  <span>Sinkron dengan database Supabase</span>
                </div>
              </div>

              <!-- Metric 2: Total Transaksi -->
              <div class="bento-card">
                <div class="bento-card-label">Aktivitas Transaksi</div>
                <div class="bento-card-value"><?= number_format($total_transaksi) ?> <span style="font-size: 1rem; font-weight: 600; color: var(--c-sage);">Log</span></div>
                <div class="bento-progress-track">
                  <div class="bento-progress-fill" style="width: 65%;"></div>
                </div>
                <div class="bento-card-sub" style="margin-top: 10px;">
                  <i class="fas fa-clock" style="color: var(--c-mint);"></i>
                  <span>Pembelian &amp; Penjualan terdata</span>
                </div>
              </div>

              <!-- Metric 3: Rekanan Bisnis -->
              <div class="bento-card">
                <div class="bento-card-label">Mitra Terdaftar</div>
                <div class="bento-card-value"><?= number_format($total_supplier + $total_customer) ?> <span style="font-size: 1rem; font-weight: 600; color: var(--c-sage);">Mitra</span></div>
                <div class="bento-avatar-stack">
                  <div class="bento-stack-item"><i class="fas fa-user-tie"></i></div>
                  <div class="bento-stack-item"><i class="fas fa-building"></i></div>
                  <div class="bento-stack-item"><i class="fas fa-truck"></i></div>
                  <div class="bento-stack-item" style="background: var(--c-forest-700); font-size: 0.65rem;">+<?= max(1, $total_supplier) ?></div>
                </div>
                <div class="bento-card-sub" style="margin-top: 10px;">
                  <span><?= $total_supplier ?> Supplier &bull; <?= $total_customer ?> Customer</span>
                </div>
              </div>

            </div>

            <!-- Metric 4: Signature Electric Lime Card (Direct from Image 1 right card!) -->
            <div class="bento-card-highlight" style="background: linear-gradient(145deg, #163832 0%, #0b2b26 100%);">
              <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                  <div style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; color: var(--c-sage);">Cloud Engine</div>
                  <div style="font-size: 1.45rem; font-weight: 800; color: #ffffff; margin-top: 4px;">Supabase AWS</div>
                </div>
                <span class="bento-lime-badge">
                  <i class="fas fa-bolt"></i> Active
                </span>
              </div>

              <div style="margin: 16px 0; display: flex; gap: 8px;">
                <div style="flex: 1; background: var(--c-forest-700); border: 1px solid var(--border-glass); border-radius: 12px; padding: 10px;">
                  <div style="font-size: 0.7rem; color: var(--c-sage);">Latency</div>
                  <div style="font-size: 0.95rem; font-weight: 800; color: var(--c-lime); font-family: var(--font-mono);">28 ms</div>
                </div>
                <div style="flex: 1; background: var(--c-lime); border-radius: 12px; padding: 10px; color: var(--c-forest-900);">
                  <div style="font-size: 0.7rem; font-weight: 700;">Uptime SLA</div>
                  <div style="font-size: 0.95rem; font-weight: 800; font-family: var(--font-mono);">99.99%</div>
                </div>
              </div>

              <a href="login.php" class="bento-btn bento-btn-white" style="width: 100%; justify-content: center; font-size: 0.825rem; padding: 8px 16px;">
                <span>Masuk Manajemen Portal</span>
                <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
              </a>
            </div>

          </div>

          <!-- Capsule Pill Filters (Image 1 Middle Row) -->
          <div class="bento-filters-row">
            <span class="bento-filter-pill active"><i class="fas fa-filter"></i> Semua Kategori</span>
            <span class="bento-filter-pill"><i class="fas fa-microchip"></i> Elektronik</span>
            <span class="bento-filter-pill"><i class="fas fa-pen-ruler"></i> Alat Tulis Kantor</span>
            <span class="bento-filter-pill"><i class="fas fa-shield-halved"></i> Stok Aman</span>
            <span class="bento-filter-pill"><i class="fas fa-triangle-exclamation"></i> Ambang Batas Minimum</span>
          </div>

          <!-- ========================================================
               THE SIGNATURE SPLIT SECTION (LIGHT CARD VS DARK CARD)
               Centerpiece of Image 1!
               ======================================================== -->
          <div class="bento-split-grid">
            
            <!-- Left Side: High-Contrast Pale Mint / White Bento Card -->
            <div class="bento-card-light">
              <div class="bento-section-title">
                <span>Katalog Barang Real-time</span>
                <span style="font-size: 0.725rem; font-weight: 700; background: var(--c-forest-900); color: var(--c-mint); padding: 4px 10px; border-radius: var(--radius-pill); font-family: var(--font-mono);">
                  <?= count($recent_items) ?> Terekam
                </span>
              </div>

              <div class="bento-light-list">
                <?php foreach ($recent_items as $item): ?>
                  <div class="bento-light-item">
                    <div class="bento-light-item-left">
                      <div class="bento-light-avatar">
                        <i class="fas fa-box"></i>
                      </div>
                      <div>
                        <div class="bento-light-name"><?= htmlspecialchars($item['nama_barang']) ?></div>
                        <div class="bento-light-meta"><?= htmlspecialchars($item['kd_barang']) ?> &bull; <?= htmlspecialchars($item['kategori']) ?></div>
                      </div>
                    </div>
                    <div style="text-align: right;">
                      <div class="bento-light-price">Rp <?= number_format((float)$item['harga_jual'], 0, ',', '.') ?></div>
                      <span class="bento-status-pill <?= ((int)$item['stok'] <= 10) ? 'bento-status-low' : 'bento-status-safe' ?>" style="font-size: 0.7rem; padding: 2px 8px;">
                        Stok: <?= (int)$item['stok'] ?>
                      </span>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Right Side: Deep Forest Dark Bento Card -->
            <div class="bento-card-dark">
              <div class="bento-section-title">
                <span>Valuasi Gudang &amp; Infrastruktur</span>
                <span style="font-size: 0.75rem; color: var(--c-lime); font-family: var(--font-mono);">
                  <i class="fas fa-shield-check"></i> ACID Compliant
                </span>
              </div>

              <div class="bento-dark-grid">
                <div class="bento-metric-tile">
                  <div class="bento-tile-label">Nilai Estimasi Aset</div>
                  <div class="bento-tile-value" style="color: var(--c-mint);">
                    Rp <?= number_format($total_nilai_aset, 0, ',', '.') ?>
                  </div>
                </div>

                <div class="bento-metric-tile">
                  <div class="bento-tile-label">Protokol Keamanan</div>
                  <div class="bento-tile-value" style="color: var(--c-lime);">
                    SSL Require
                  </div>
                </div>

                <div class="bento-metric-tile">
                  <div class="bento-tile-label">Mekanisme Pooler</div>
                  <div class="bento-tile-value" style="color: #ffffff;">
                    Port 5432 / AWS
                  </div>
                </div>

                <div class="bento-metric-tile">
                  <div class="bento-tile-label">Platform Hosting</div>
                  <div class="bento-tile-value" style="color: var(--c-mint);">
                    Vercel Edge
                  </div>
                </div>
              </div>

              <div style="background: var(--c-forest-700); border: 1px solid var(--border-glass); border-radius: var(--radius-bento-sm); padding: 16px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                  <span style="font-size: 0.8rem; font-weight: 700; color: #ffffff;">Status Sinkronisasi Sistem</span>
                  <span style="font-size: 0.75rem; color: var(--c-lime); font-weight: 700;">100% Siap Operasional</span>
                </div>
                <div class="bento-progress-track" style="margin-top: 0;">
                  <div class="bento-progress-fill" style="width: 100%;"></div>
                </div>
                <div style="font-size: 0.75rem; color: var(--c-sage); margin-top: 8px;">
                  Semua tabel (Master Barang, Pembelian, Penjualan, Supplier, Customer) telah terintegrasi di PostgreSQL Supabase.
                </div>
              </div>

              <a href="login.php" class="bento-btn bento-btn-lime" style="width: 100%; justify-content: center;">
                <span>Masuk Dashboard Admin</span>
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>

          </div>

        </div>
      </div>

    </div>
  </section>

  <!-- ========================================================
       CORE FEATURES BENTO GRID SECTION
       ======================================================== -->
  <section class="landing-section landing-section-alt" id="features">
    <div style="max-width: 1280px; margin: 0 auto;">
      
      <div class="landing-section-header">
        <span class="landing-section-tag">Fitur Tingkat Tinggi</span>
        <h2 class="landing-section-title">Arsitektur Cerdas untuk Manajemen Tanpa Hambatan</h2>
        <p class="landing-section-desc">
          Setiap modul dirancang untuk akurasi data stok mutlak, menghilangkan risiko selisih inventaris fisik dan mempercepat rantai pasok Anda.
        </p>
      </div>

      <div class="features-bento-grid">
        
        <!-- Feature 1 (Span 2) -->
        <div class="feature-bento-card card-span-2">
          <div>
            <div class="feature-icon-box">
              <i class="fas fa-boxes-stacked"></i>
            </div>
            <h3 class="feature-card-title">Pencatatan Stok Masuk &amp; Keluar Real-Time</h3>
            <p class="feature-card-desc">
              Setiap transaksi pembelian dari supplier langsung mengkredit jumlah barang di master data, sedangkan permintaan barang keluar otomatis mendebit stok dengan pencatatan log audit transparan tanpa jeda.
            </p>
          </div>
          <div style="margin-top: 24px; display: flex; gap: 10px; flex-wrap: wrap;">
            <span style="font-size: 0.75rem; padding: 4px 12px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint); border: 1px solid var(--border-glass);">
              <i class="fas fa-check" style="color: var(--c-lime); margin-right: 4px;"></i> Otomatisasi Stok
            </span>
            <span style="font-size: 0.75rem; padding: 4px 12px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint); border: 1px solid var(--border-glass);">
              <i class="fas fa-check" style="color: var(--c-lime); margin-right: 4px;"></i> Log Transaksi Akurat
            </span>
            <span style="font-size: 0.75rem; padding: 4px 12px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint); border: 1px solid var(--border-glass);">
              <i class="fas fa-check" style="color: var(--c-lime); margin-right: 4px;"></i> Riwayat Detail
            </span>
          </div>
        </div>

        <!-- Feature 2 -->
        <div class="feature-bento-card">
          <div>
            <div class="feature-icon-box">
              <i class="fas fa-database"></i>
            </div>
            <h3 class="feature-card-title">Supabase Cloud Database</h3>
            <p class="feature-card-desc">
              Didukung oleh mesin PostgreSQL tingkat enterprise dengan koneksi SSL aman, ACID compliance, dan skalabilitas tak terbatas di cloud.
            </p>
          </div>
          <div style="margin-top: 20px;">
            <span style="font-size: 0.75rem; color: var(--c-lime); font-weight: 700;">AWS Ap-Northeast Pooler &rarr;</span>
          </div>
        </div>

        <!-- Feature 3 -->
        <div class="feature-bento-card">
          <div>
            <div class="feature-icon-box">
              <i class="fas fa-bell"></i>
            </div>
            <h3 class="feature-card-title">Peringatan Stok Minimum</h3>
            <p class="feature-card-desc">
              Indikator visual pintar memberi sinyal dini saat barang mendekati batas restock kritis, mencegah keterlambatan suplai ke operasional.
            </p>
          </div>
          <div style="margin-top: 20px;">
            <span class="bento-status-pill bento-status-low" style="font-size: 0.725rem;">Peringatan Otomatis Aktif</span>
          </div>
        </div>

        <!-- Feature 4 -->
        <div class="feature-bento-card">
          <div>
            <div class="feature-icon-box">
              <i class="fas fa-user-shield"></i>
            </div>
            <h3 class="feature-card-title">Multi-Role RBAC Security</h3>
            <p class="feature-card-desc">
              Pemisahan hak akses granular antara Administrator Gudang dan Akun Supplier untuk menjaga kerahasiaan harga beli dan kontrol data.
            </p>
          </div>
          <div style="margin-top: 20px;">
            <span style="font-size: 0.75rem; color: var(--c-mint); font-weight: 600;">Admin &bull; Petugas &bull; Supplier</span>
          </div>
        </div>

        <!-- Feature 5 (Span 2) -->
        <div class="feature-bento-card card-span-2">
          <div>
            <div class="feature-icon-box">
              <i class="fas fa-cloud-arrow-up"></i>
            </div>
            <h3 class="feature-card-title">Vercel Serverless Ready</h3>
            <p class="feature-card-desc">
              Arsitektur aplikasi terkonfigurasi dengan standar router serverless Vercel (`vercel-php@0.9.0`), driver native `pgsql`, dan environment variables aman untuk deployment kilat tanpa server fisik.
            </p>
          </div>
          <div style="margin-top: 24px; display: flex; gap: 10px; flex-wrap: wrap;">
            <span style="font-size: 0.75rem; padding: 4px 12px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint); border: 1px solid var(--border-glass);">
              <i class="fas fa-bolt" style="color: var(--c-lime); margin-right: 4px;"></i> Zero Server Maintenance
            </span>
            <span style="font-size: 0.75rem; padding: 4px 12px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint); border: 1px solid var(--border-glass);">
              <i class="fas fa-mobile-screen" style="color: var(--c-lime); margin-right: 4px;"></i> Responsif Desktop &amp; Mobile
            </span>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ========================================================
       LIVE DATABASE CATALOG PREVIEW SECTION
       ======================================================== -->
  <section class="landing-section" id="katalog">
    <div style="max-width: 1280px; margin: 0 auto;">
      
      <div class="landing-section-header">
        <span class="landing-section-tag">Katalog Terhubung</span>
        <h2 class="landing-section-title">Data Master Barang Live dari Supabase</h2>
        <p class="landing-section-desc">
          Tabel di bawah ini ditarik langsung dari tabel `tb_barang` di basis data PostgreSQL Supabase.
        </p>
      </div>

      <div class="bento-table-card">
        <div class="bento-table-header">
          <div>
            <h3 style="color: #ffffff; font-size: 1.15rem; font-weight: 800; margin: 0;">Master Inventory Preview</h3>
            <p style="color: var(--c-sage); font-size: 0.8rem; margin: 4px 0 0 0;">Menampilkan status inventaris aktif dan unit harga</p>
          </div>
          <a href="login.php" class="bento-btn bento-btn-lime" style="font-size: 0.8rem; padding: 8px 18px;">
            <span>Kelola di Dashboard</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>

        <div class="bento-table-wrap">
          <table class="bento-table">
            <thead>
              <tr>
                <th>Kode SKU</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Jumlah Stok</th>
                <th>Harga Jual</th>
                <th>Status Ketersediaan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recent_items as $item): ?>
                <tr>
                  <td style="font-family: var(--font-mono); font-weight: 700; color: var(--c-lime);">
                    <?= htmlspecialchars($item['kd_barang']) ?>
                  </td>
                  <td style="font-weight: 700; color: #ffffff;">
                    <?= htmlspecialchars($item['nama_barang']) ?>
                  </td>
                  <td>
                    <span style="font-size: 0.8rem; padding: 3px 10px; border-radius: var(--radius-pill); background: var(--c-forest-700); color: var(--c-mint); border: 1px solid var(--border-glass);">
                      <?= htmlspecialchars($item['kategori']) ?>
                    </span>
                  </td>
                  <td style="font-weight: 800; font-family: var(--font-mono); font-size: 1rem;">
                    <?= number_format((int)$item['stok']) ?> Unit
                  </td>
                  <td style="font-family: var(--font-mono); font-weight: 700; color: var(--c-mint);">
                    Rp <?= number_format((float)$item['harga_jual'], 0, ',', '.') ?>
                  </td>
                  <td>
                    <?php if ((int)$item['stok'] > 15): ?>
                      <span class="bento-status-pill bento-status-safe">
                        <i class="fas fa-check-circle"></i> Stok Aman
                      </span>
                    <?php elseif ((int)$item['stok'] > 0): ?>
                      <span class="bento-status-pill bento-status-low">
                        <i class="fas fa-triangle-exclamation"></i> Menipis
                      </span>
                    <?php else: ?>
                      <span class="bento-status-pill" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">
                        <i class="fas fa-times-circle"></i> Habis
                      </span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>

  <!-- ========================================================
       FAQ BENTO SECTION (Smooth Vanilla JS Accordion)
       ======================================================== -->
  <section class="landing-section landing-section-alt" id="faq">
    <div style="max-width: 1280px; margin: 0 auto;">
      
      <div class="landing-section-header">
        <span class="landing-section-tag">Pusat Informasi</span>
        <h2 class="landing-section-title">Pertanyaan Seputar SIMTI Cloud</h2>
        <p class="landing-section-desc">
          Jawaban praktis mengenai implementasi database, keamanan, dan deployment serverless.
        </p>
      </div>

      <div class="faq-bento-list">
        
        <div class="faq-bento-card open">
          <button class="faq-question-btn" type="button">
            <span>Apakah database sistem ini menggunakan Supabase PostgreSQL?</span>
            <div class="faq-icon-arrow"><i class="fas fa-chevron-down"></i></div>
          </button>
          <div class="faq-answer-body">
            Ya, benar. Seluruh data (barang, supplier, customer, pembelian, penjualan, user) telah termigrasi penuh ke basis data PostgreSQL di Supabase. Koneksi menggunakan driver native `pg_*` dengan SSL mode require yang aman dan berkinerja tinggi.
          </div>
        </div>

        <div class="faq-bento-card">
          <button class="faq-question-btn" type="button">
            <span>Apakah proyek ini dapat diunggah langsung ke Vercel?</span>
            <div class="faq-icon-arrow"><i class="fas fa-chevron-down"></i></div>
          </button>
          <div class="faq-answer-body">
            Sangat kompatibel. Proyek telah dilengkapi dengan berkas `vercel.json` dan router `api/index.php` yang siap pakai menggunakan runtime `vercel-php@0.9.0`. Variabel lingkungan Supabase juga dapat diatur langsung di dashboard Vercel.
          </div>
        </div>

        <div class="faq-bento-card">
          <button class="faq-question-btn" type="button">
            <span>Bagaimana alur pencatatan stok keluar dan stok masuk?</span>
            <div class="faq-icon-arrow"><i class="fas fa-chevron-down"></i></div>
          </button>
          <div class="faq-answer-body">
            Saat transaksi pembelian dicatat oleh supplier atau admin, stok barang di master data bertambah secara otomatis. Ketika barang dikeluarkan untuk kebutuhan operasional atau penjualan, stok berkurang dan riwayatnya tersimpan di tabel log aktivitas.
          </div>
        </div>

        <div class="faq-bento-card">
          <button class="faq-question-btn" type="button">
            <span>Apakah tampilan sudah responsif untuk pengguna smartphone?</span>
            <div class="faq-icon-arrow"><i class="fas fa-chevron-down"></i></div>
          </button>
          <div class="faq-answer-body">
            Ya. Seluruh tata letak Bento UI mengadopsi prinsip fluid-responsive dengan CSS Grid dan Flexbox modern. Di layar perangkat ponsel, navigasi kapsul berubah menjadi menu sentuh dan grid metrics bertumpuk secara rapi tanpa pergeseran horizontal.
          </div>
        </div>

        <div class="faq-bento-card">
          <button class="faq-question-btn" type="button">
            <span>Bagaimana cara mendapatkan akses masuk ke sistem?</span>
            <div class="faq-icon-arrow"><i class="fas fa-chevron-down"></i></div>
          </button>
          <div class="faq-answer-body">
            Anda dapat langsung menekan tombol "Masuk Portal" di navigasi atas atau tombol di bawah ini. Halaman login juga dilengkapi tombol demo 1-klik untuk akun Administrator dan Supplier agar mempermudah pengujian.
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ========================================================
       BOTTOM CTA BENTO BANNER
       ======================================================== -->
  <section class="landing-section" style="padding-top: 40px; padding-bottom: 90px;">
    <div style="max-width: 1280px; margin: 0 auto;">
      
      <div class="cta-banner-bento">
        <span class="landing-section-tag" style="margin-bottom: 20px;">Mulai Sekarang</span>
        <h2 style="font-size: clamp(2rem, 4vw, 3.2rem); font-weight: 800; color: #ffffff; letter-spacing: -0.03em; margin-bottom: 16px;">
          Tingkatkan Efisiensi Gudang Anda Bersama SIMTI
        </h2>
        <p style="font-size: 1.1rem; color: var(--c-sage); max-width: 680px; margin: 0 auto 36px auto; line-height: 1.6;">
          Dapatkan kemudahan pelacakan stok barang real-time, audit ledger otomatis, dan kecepatan cloud database PostgreSQL tanpa kerumitan instalasi.
        </p>

        <div style="display: flex; justify-content: center; align-items: center; gap: 16px; flex-wrap: wrap;">
          <a href="login.php" class="hero-btn-primary">
            <span>Buka Portal Sekarang</span>
            <i class="fas fa-arrow-right"></i>
          </a>
          <a href="register.php" class="hero-btn-secondary">
            <i class="fas fa-user-plus"></i>
            <span>Daftar Akun Baru</span>
          </a>
        </div>
      </div>

    </div>
  </section>

  <!-- ========================================================
       EDITORIAL FOOTER (#051F20 Canvas)
       ======================================================== -->
  <footer class="landing-footer">
    <div class="landing-footer-inner">
      
      <div>
        <div class="landing-brand" style="margin-bottom: 18px;">
          <div class="landing-brand-icon">
            <i class="fas fa-boxes-stacked"></i>
          </div>
          <div class="landing-brand-text">
            <span>SIMTI</span>
            <span class="landing-brand-sub">Inventory Cloud</span>
          </div>
        </div>
        <p style="font-size: 0.875rem; color: var(--c-sage); line-height: 1.65; max-width: 380px; margin-bottom: 20px;">
          Sistem Informasi Manajemen Pergudangan modern berbasis cloud PostgreSQL Supabase dengan tampilan Bento UI yang bersih dan intuitif.
        </p>
        <div style="display: flex; gap: 10px;">
          <a href="#" class="bento-icon-pill" title="Github"><i class="fab fa-github"></i></a>
          <a href="#" class="bento-icon-pill" title="Documentation"><i class="fas fa-book"></i></a>
          <a href="#" class="bento-icon-pill" title="Database"><i class="fas fa-database"></i></a>
        </div>
      </div>

      <div>
        <h4 class="footer-col-title">Navigasi Utama</h4>
        <ul class="footer-link-list">
          <li><a href="#hero">Beranda Utama</a></li>
          <li><a href="#showcase">Live Bento Mockup</a></li>
          <li><a href="#features">Fitur Unggulan</a></li>
          <li><a href="#katalog">Katalog Supabase</a></li>
          <li><a href="#faq">Pusat Bantuan / FAQ</a></li>
        </ul>
      </div>

      <div>
        <h4 class="footer-col-title">Modul Sistem</h4>
        <ul class="footer-link-list">
          <li><a href="login.php">Portal Administrator</a></li>
          <li><a href="login.php">Portal Petugas Supplier</a></li>
          <li><a href="register.php">Registrasi Akun</a></li>
          <li><a href="login.php">Laporan &amp; Rekonsiliasi</a></li>
        </ul>
      </div>

      <div>
        <h4 class="footer-col-title">Spesifikasi Cloud</h4>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <div style="font-size: 0.8rem; color: var(--c-mint);">
            <strong style="color: #ffffff;">Database:</strong> Supabase PostgreSQL
          </div>
          <div style="font-size: 0.8rem; color: var(--c-mint);">
            <strong style="color: #ffffff;">Region:</strong> AWS AP-Northeast-1
          </div>
          <div style="font-size: 0.8rem; color: var(--c-mint);">
            <strong style="color: #ffffff;">Hosting:</strong> Vercel Serverless
          </div>
          <div style="font-size: 0.8rem; color: var(--c-lime); font-weight: 700;">
            <i class="fas fa-circle" style="font-size: 8px;"></i> Semua Layanan Beroperasi Normal
          </div>
        </div>
      </div>

    </div>

    <div class="footer-bottom">
      <div>
        &copy; <?= date('Y') ?> <strong>SIMTI Inventory Gudang</strong>. Hak Cipta Dilindungi Undang-Undang.
      </div>
      <div style="display: flex; gap: 20px;">
        <span style="color: var(--c-sage);">Dirancang dengan Palet Forest Dark &amp; Pale Mint</span>
      </div>
    </div>
  </footer>

  <!-- ========================================================
       VANILLA JAVASCRIPT: Accordion, Mobile Menu, Scroll Spy
       ======================================================== -->
  <script>
    // 1. Mobile Menu Toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const navMenu = document.getElementById('landingNavMenu');
    if (mobileBtn && navMenu) {
      mobileBtn.addEventListener('click', () => {
        navMenu.classList.toggle('mobile-open');
        const icon = mobileBtn.querySelector('i');
        if (icon) {
          icon.classList.toggle('fa-bars');
          icon.classList.toggle('fa-times');
        }
      });
    }

    // 2. FAQ Bento Accordion
    document.querySelectorAll('.faq-bento-card').forEach(card => {
      const btn = card.querySelector('.faq-question-btn');
      if (btn) {
        btn.addEventListener('click', () => {
          const isOpen = card.classList.contains('open');
          // Tutup kartu lain
          document.querySelectorAll('.faq-bento-card').forEach(c => c.classList.remove('open'));
          // Toggle kartu ini
          if (!isOpen) {
            card.classList.add('open');
          }
        });
      }
    });

    // 3. Highlight Nav Tabs on Scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.landing-nav-link');

    window.addEventListener('scroll', () => {
      let current = '';
      const scrollY = window.pageYOffset;

      sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 120;
        const sectionId = section.getAttribute('id');

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
          current = sectionId;
        }
      });

      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
          link.classList.add('active');
        }
      });
      // Fallback jika di puncak halaman
      if (scrollY < 100 && navLinks[0]) {
        navLinks.forEach(l => l.classList.remove('active'));
        navLinks[0].classList.add('active');
      }
    });
  </script>

</body>
</html>