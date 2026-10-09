<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['tipe_user'] != 'Supplier') {
    header("Location: /login.php");
    exit();
}
require_once __DIR__ . '/../../koneksi.php';

$sup_email = $_SESSION['username'];
$res_sup = pg_query($conn, "SELECT * FROM tb_supplier WHERE email_supplier = '$sup_email'");
$supplier_data = ($res_sup && pg_num_rows($res_sup) > 0) ? pg_fetch_assoc($res_sup) : null;
$id_supplier = $supplier_data['id_supplier'] ?? '';

// PO Pesanan dari Admin
$po_list = pg_query($conn, "SELECT * FROM tb_pembelian WHERE id_supplier = '$id_supplier' ORDER BY no_pembelian DESC LIMIT 5");
$total_po = $po_list ? pg_num_rows($po_list) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard Supplier - SIMTI Inventory</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="/assets/css/clean-ui.css">

  <style>
    .welcome-banner {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      border-radius: var(--radius-xl);
      padding: 32px 36px;
      color: white;
      margin-bottom: 28px;
      position: relative;
      overflow: hidden;
      box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.3);
    }
  </style>
</head>
<body>
  <div class="container-scroller d-flex">
    <?php include 'navbar.php'; ?>

    <div class="container-fluid page-body-wrapper p-0">
      <div class="main-panel w-100">
        <div class="content-wrapper">

          <div class="welcome-banner">
            <div class="badge-clean primary mb-3" style="background: rgba(255,255,255,0.2); color: white;">
              <span class="pulse-dot"></span>
              <span>Portal Mitra Supplier Aktif</span>
            </div>
            <h1 class="welcome-title" style="color: white !important;">
              Selamat Datang, <?= htmlspecialchars($supplier_data['nama_supplier'] ?? $sup_email) ?>!
            </h1>
            <p style="color: #e0f2fe; margin-bottom: 0;">
              Pantau pesanan stok (Purchase Orders) dari gudang pusat dan konfirmasi pengiriman barang.
            </p>
          </div>

          <div class="card">
            <div class="card-body">
              <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <div>
                  <h4 class="card-title mb-0">Daftar Pesanan Masuk (PO)</h4>
                  <p class="card-description mb-0">Pesanan pembelian stok yang ditujukan kepada Anda</p>
                </div>
                <a href="/backend/suplier/pembelian/transaksi_pembelian.php" class="btn btn-primary btn-sm">
                  Lihat Semua PO <i class="fa-solid fa-arrow-right"></i>
                </a>
              </div>

              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No Pembelian</th>
                      <th>Tanggal</th>
                      <th>Total Barang</th>
                      <th>Total Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($po_list && pg_num_rows($po_list) > 0): ?>
                      <?php while ($po = pg_fetch_assoc($po_list)): ?>
                        <tr>
                          <td><strong><?= htmlspecialchars($po['no_pembelian']) ?></strong></td>
                          <td><?= htmlspecialchars($po['tanggal_pembelian']) ?></td>
                          <td><?= (int)$po['total_barangall'] ?> unit</td>
                          <td>Rp <?= number_format($po['total_hargaall'] ?? 0, 0, ',', '.') ?></td>
                          <td>
                            <a href="/backend/suplier/pembelian/detail_pembelian.php?no_pembelian=<?= urlencode($po['no_pembelian']) ?>" class="btn btn-secondary btn-sm">
                              Detail PO
                            </a>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                          Belum ada pesanan pembelian baru untuk akun Anda.
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <?php include_once __DIR__ . '/../../include/footer.php'; ?>
      </div>
    </div>
  </div>

  <script src="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/vendors/js/vendor.bundle.base.js"></script>
  <script src="/assets/Template/SpicaAdmin-Free-Bootstrap-Admin-Template-master/template/js/off-canvas.js"></script>
</body>
</html>