-- ==========================================================
-- SKEMA DATABASE POSTGRESQL UNTUK SUPABASE
-- Web-Inventory / SIMTI
-- ==========================================================

-- 1. TABEL USER (ADMIN)
-- Catatan: "user" adalah reserved keyword di PostgreSQL sehingga diberi tanda kutip dua.
CREATE TABLE IF NOT EXISTS "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tipe_user VARCHAR(50) DEFAULT 'Administrator'
);

-- 2. TABEL CUSTOMER
CREATE TABLE IF NOT EXISTS tb_customer (
    id_customer VARCHAR(50) PRIMARY KEY,
    nama_customer VARCHAR(150) NOT NULL,
    jenis_kelamin VARCHAR(20),
    alamat_customer TEXT,
    telepon_customer VARCHAR(50),
    email_customer VARCHAR(100) UNIQUE,
    pass_customer VARCHAR(255) NOT NULL
);

-- 3. TABEL SUPPLIER
CREATE TABLE IF NOT EXISTS tb_supplier (
    id_supplier VARCHAR(50) PRIMARY KEY,
    nama_supplier VARCHAR(150) NOT NULL,
    alamat_supplier TEXT,
    telepon_supplier VARCHAR(50),
    email_supplier VARCHAR(100) UNIQUE,
    pass_supplier VARCHAR(255) NOT NULL
);

-- 4. TABEL KATEGORI BARANG
CREATE TABLE IF NOT EXISTS kategori_barang (
    id_kategori VARCHAR(50) PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

-- 5. TABEL BARANG
CREATE TABLE IF NOT EXISTS tb_barang (
    kd_barang VARCHAR(50) PRIMARY KEY,
    kode_jenis VARCHAR(50),
    nama_barang VARCHAR(150) NOT NULL,
    stok INT DEFAULT 0,
    harga_beli NUMERIC(15, 2) DEFAULT 0,
    harga_jual NUMERIC(15, 2) DEFAULT 0,
    gambar_produk VARCHAR(255)
);

-- 6. TABEL STOK KELUAR / PERMINTAAN
CREATE TABLE IF NOT EXISTS stok_keluar (
    id SERIAL PRIMARY KEY,
    kd_barang VARCHAR(50),
    jumlah INT DEFAULT 0,
    tanggal DATE DEFAULT CURRENT_DATE,
    alasan TEXT
);

-- 7. TABEL KARYAWAN
CREATE TABLE IF NOT EXISTS tb_karyawan (
    id_karyawan VARCHAR(50) PRIMARY KEY,
    nama_karyawan VARCHAR(150) NOT NULL,
    jabatan VARCHAR(100)
);

-- 8. TABEL PEMBELIAN
CREATE TABLE IF NOT EXISTS tb_pembelian (
    no_pembelian VARCHAR(50) PRIMARY KEY,
    tanggal_pembelian DATE DEFAULT CURRENT_DATE,
    id_supplier VARCHAR(50),
    total_barangall INT DEFAULT 0,
    total_hargaall NUMERIC(15, 2) DEFAULT 0
);

-- 9. TABEL DETAIL PEMBELIAN
CREATE TABLE IF NOT EXISTS detail_pembelian (
    id SERIAL PRIMARY KEY,
    no_pembelian VARCHAR(50),
    kd_barang VARCHAR(50),
    nama_barang VARCHAR(150),
    jumlah INT DEFAULT 0,
    harga_satuan NUMERIC(15, 2) DEFAULT 0,
    total_harga NUMERIC(15, 2) DEFAULT 0
);

-- 10. TABEL PENJUALAN
CREATE TABLE IF NOT EXISTS tb_penjualan (
    no_penjualan VARCHAR(50) PRIMARY KEY,
    tanggal_penjualan DATE DEFAULT CURRENT_DATE,
    id_customer VARCHAR(50),
    total_barangall INT DEFAULT 0,
    total_hargaall NUMERIC(15, 2) DEFAULT 0
);

-- 11. TABEL LOG AKTIVITAS
CREATE TABLE IF NOT EXISTS log_aktivitas (
    id_log SERIAL PRIMARY KEY,
    id_user VARCHAR(50),
    aktivitas TEXT,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 12. TABEL PEMBAYARAN & LAPORAN ARUS KAS
CREATE TABLE IF NOT EXISTS pembayaran (
    id_pembayaran VARCHAR(50) PRIMARY KEY,
    no_transaksi VARCHAR(50) NOT NULL,
    jenis_transaksi VARCHAR(50) NOT NULL,
    metode VARCHAR(50) DEFAULT 'Transfer Bank',
    status VARCHAR(50) DEFAULT 'Selesai',
    tanggal DATE DEFAULT CURRENT_DATE,
    total NUMERIC(15, 2) DEFAULT 0
);

-- ==========================================================
-- DATA AWAL / SAMPLE DATA
-- ==========================================================

-- Data Admin (Login Admin: admin / admin123)
INSERT INTO "user" (username, password, tipe_user) 
VALUES ('admin', 'admin123', 'Administrator')
ON CONFLICT (username) DO NOTHING;

-- Data Customer (Login Customer: customer@mail.com / cust123)
INSERT INTO tb_customer (id_customer, nama_customer, jenis_kelamin, alamat_customer, telepon_customer, email_customer, pass_customer)
VALUES ('CST-001', 'Budi Santoso', 'Laki-laki', 'Jl. Merdeka No. 45 Jakarta', '081234567890', 'customer@mail.com', 'cust123')
ON CONFLICT (id_customer) DO NOTHING;

-- Data Supplier (Login Supplier: supplier@mail.com / sup123)
INSERT INTO tb_supplier (id_supplier, nama_supplier, alamat_supplier, telepon_supplier, email_supplier, pass_supplier)
VALUES ('SPL-001', 'PT Sumber Makmur', 'Jl. Industri No. 12 Bekasi', '081398765432', 'supplier@mail.com', 'sup123')
ON CONFLICT (id_supplier) DO NOTHING;

-- Data Kategori Barang
INSERT INTO kategori_barang (id_kategori, nama_kategori)
VALUES 
    ('KTG-001', 'Elektronik'),
    ('KTG-002', 'Alat Tulis Kantor'),
    ('KTG-003', 'Perabotan')
ON CONFLICT (id_kategori) DO NOTHING;

-- Data Barang
INSERT INTO tb_barang (kd_barang, kode_jenis, nama_barang, stok, harga_beli, harga_jual, gambar_produk)
VALUES 
    ('BRG-001', 'KTG-001', 'Keyboard Mekanikal RGB', 25, 350000.00, 450000.00, 'keyboard.jpg'),
    ('BRG-002', 'KTG-001', 'Mouse Wireless Silent', 40, 120000.00, 165000.00, 'mouse.jpg'),
    ('BRG-003', 'KTG-002', 'Kertas HVS A4 80gr (Rim)', 100, 48000.00, 58000.00, 'kertas.jpg')
ON CONFLICT (kd_barang) DO NOTHING;

-- Data Karyawan
INSERT INTO tb_karyawan (id_karyawan, nama_karyawan, jabatan)
VALUES 
    ('KRY-001', 'Ahmad Fauzi', 'Manager Gudang'),
    ('KRY-002', 'Siti Rahma', 'Staff Admin Gudang')
ON CONFLICT (id_karyawan) DO NOTHING;
