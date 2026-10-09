<div align="center">

  <img src="assets/images/logo.png" alt="SIMTI Logo" width="100" height="100" style="border-radius: 20px; margin-bottom: 12px;" />

  # 📦 SIMTI — Inventory Management System
  **Sistem Informasi Manajemen & Tracking Inventaris Modern Berbasis Web**

  [![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net/)
  [![PostgreSQL](https://img.shields.io/badge/Supabase_PostgreSQL-336791?style=for-the-badge&logo=postgresql&logoColor=white)](https://supabase.com/)
  [![Vercel](https://img.shields.io/badge/Vercel-Ready-000000?style=for-the-badge&logo=vercel&logoColor=white)](https://vercel.com/)
  [![License](https://img.shields.io/badge/License-MIT-brightgreen?style=for-the-badge)](LICENSE)

  <p align="center">
    Aplikasi manajemen rantai pasok (supply chain) dan pergudangan modern dengan arsitektur <b>Bento UI</b> elegan, palet warna <i>Forest Dark & Neon Lime</i>, multi-role portal (Admin, Supplier, Customer), serta integrasi penuh ke <b>Supabase Cloud PostgreSQL</b> yang siap di-deploy ke <b>Vercel Serverless</b>.
  </p>

</div>

---

## ✨ Fitur Unggulan

### 1. 🛡️ Multi-Role Ecosystem
* **👑 Administrator Portal:**
  * Dashboard metrik analitik: Total Barang, Valuasi Aset Inventaris, Transaksi Penjualan, dan Pengadaan Pembelian.
  * Manajemen Data Master: Master Barang, Kategori, Supplier, dan Pelanggan.
  * Transaksi Penjualan & Pembelian lengkap dengan detail item dan invoice.
  * Riwayat Log Aktivitas sistem secara real-time.
* **🚚 Supplier Portal:**
  * Dashboard pesanan masuk dan status pengiriman pasokan.
  * Form pengadaan suplai barang ke gudang.
  * Riwayat transaksi pembelian dari pihak manajemen.
* **🛒 Customer Portal:**
  * Katalog produk interaktif dengan informasi stok langsung dari database.
  * Tracking riwayat pesanan dan rincian transaksi belanja.

### 2. 🎨 UI/UX Bento Modern & Responsive
* **Bespoke Bento Grid:** Tampilan modular tanpa kesan template kaku.
* **Forest Dark & Lime Accent:** Palet warna eksklusif (`#051F20`, `#163832`, `#8EB69B`, `#a3e635`).
* **Custom Alert Transitions:** Tidak menggunakan pop-up browser bawaan (`alert()`), melainkan kartu notifikasi Bento dinamis dengan progress bar otomatis.
* **Mobile-Friendly:** Responsif diakses dari smartphone, tablet, maupun layar desktop lebar.

### 3. ☁️ Cloud Database & Serverless Architecture
* Terintegrasi langsung dengan **Supabase PostgreSQL** via Session Pooler (port `5432` / `6543`).
* Dilengkapi front controller `api/index.php` dan `vercel.json` untuk kemudahan deployment 1-klik di **Vercel**.

---

## 🛠️ Tech Stack

| Layer | Teknologi |
| :--- | :--- |
| **Backend** | PHP 8.x Native (Clean, modular, structured) |
| **Database** | PostgreSQL hosted on [Supabase](https://supabase.com/) |
| **Frontend** | HTML5, Modern CSS (Bento Design System), Vanilla JavaScript |
| **Icons & Fonts** | Plus Jakarta Sans, Custom SVG Icons |
| **Deployment** | Vercel Serverless (`vercel-php`) & Local (Laragon / Apache / PHP CLI) |

---

## 🔑 Akun Demo (Credentials)

Untuk pengujian cepat, akun bawaan sudah disiapkan di database:

| Role | Username / Email | Password | Akses Dashboard |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin` | `admin123` | Portal Admin Lengkap |
| **Supplier** | `supplier@mail.com` | `sup123` | Portal Mitra Supplier |
| **Customer** | `customer@mail.com` | `cust123` | Portal Pelanggan / Belanja |

---

## 🚀 Panduan Menjalankan Secara Lokal

### Prasyarat:
* PHP $\ge$ 8.0 dengan ekstensi `pdo_pgsql` atau `pgsql` aktif.
* Git & Web Server lokal (Laragon / XAMPP) atau PHP Built-in Server.

### Langkah-langkah:

1. **Clone Repository:**
   ```bash
   git clone https://github.com/Muhamadsolehs/Website-InventoryManagementSystem.git
   cd Website-InventoryManagementSystem
   ```

2. **Setup Database Supabase:**
   * Buat project baru di [Supabase Dashboard](https://supabase.com/).
   * Masuk ke **SQL Editor** di Supabase, lalu jalankan script yang ada di [`supabase_schema.sql`](supabase_schema.sql).

3. **Konfigurasi Koneksi:**
   * File [`koneksi.php`](koneksi.php) sudah mendukung Environment Variables dan fallback default.
   * Anda bisa menyesuaikan kredensial di [`koneksi.php`](koneksi.php) jika menggunakan instance database sendiri.

4. **Jalankan Aplikasi:**
   ```bash
   php -S localhost:8080
   ```
   Buka browser dan akses: `http://localhost:8080`

---

## ☁️ Panduan Deployment ke Vercel

Proyek ini sudah dilengkapi dengan [`vercel.json`](vercel.json) dan router [`api/index.php`](api/index.php).

1. Login ke [Vercel](https://vercel.com/) menggunakan akun GitHub.
2. Klik **Add New...** $\rightarrow$ **Project**, lalu pilih repository `Website-InventoryManagementSystem`.
3. Di bagian **Environment Variables**, tambahkan:
   * `SUPABASE_HOST` = `aws-0-ap-northeast-1.pooler.supabase.com`
   * `SUPABASE_PORT` = `5432`
   * `SUPABASE_DB` = `postgres`
   * `SUPABASE_USER` = `postgres.dpuetzbypujalrtejmiu`
   * `SUPABASE_PASSWORD` = `[PASSWORD_SUPABASE_ANDA]`
4. Klik **Deploy** dan website langsung aktif secara publik!

---

## 📁 Struktur Direktori

```text
├── api/
│   └── index.php            # Vercel serverless router & front-controller
├── assets/
│   ├── css/
│   │   └── clean-ui.css     # Bento design system & Forest Dark palette
│   └── images/              # Logo, icon, dan aset gambar
├── backend/
│   ├── admin/               # Modul manajemen Administrator
│   │   ├── barang/          # Master data barang
│   │   ├── pembelian/       # Transaksi PO pengadaan
│   │   ├── penjualan/       # Transaksi invoice penjualan
│   │   ├── suplier/         # Master mitra supplier
│   │   └── customer/        # Master pelanggan
│   ├── customer/            # Portal khusus Customer & katalog
│   └── suplier/             # Portal khusus Supplier & transaksi pasokan
├── include/
│   ├── bento_header.php     # Header & navigasi universal
│   └── footer.php           # Footer komponen
├── index.php                # Landing page utama (Bento Showcase)
├── login.php                # Halaman autentikasi multi-role
├── proses.php               # Handler login, logout, & Bento alerts
├── koneksi.php              # Koneksi Supabase PostgreSQL
├── supabase_schema.sql      # Skema tabel & data seed SQL
└── vercel.json              # Konfigurasi deployment Vercel
```

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi [MIT License](LICENSE). Bebas digunakan dan dikembangkan untuk keperluan edukasi maupun komersial.

<div align="center">
  <sub>Dikembangkan dengan penuh dedikasi oleh <a href="https://github.com/Muhamadsolehs">Muhamad Soleh</a></sub>
</div>
