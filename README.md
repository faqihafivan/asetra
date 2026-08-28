# ASETRA — Asset & Inventory Management System

ASETRA (Asset & Inventory Management System) adalah aplikasi berbasis web yang dirancang untuk mengelola inventaris, aset, transaksi pengadaan (barang masuk), pendistribusian (barang keluar), pencetakan label stiker KIR (Kartu Inventaris Ruangan) ber-QR Code, hingga pelaporan otomatis.

---

## ✨ Fitur Utama

- **📊 Dashboard Interaktif & Statistik Real-Time:** Ringkasan total aset, transaksi pengadaan, barang keluar, nilai total persediaan, grafik tren bulanan, dan peringatan stok menipis (*low stock alert*).
- **📦 Manajemen Data Master:** Pengelolaan data Kategori, Lokasi/Ruangan, Supplier, dan Sumber Dana.
- **🏷️ Data Barang & Cetak Label Stiker KIR:** Pencatatan spesifikasi barang, nomor inventaris otomatis, kontrol batas stok minimum, dan fitur cetak stiker label KIR berukuran standar 80mm x 40mm yang dilengkapi dengan **QR Code dinamis**.
- **📥 Transaksi Pengadaan (Barang Masuk):** Pencatatan nota belanja / bukti invoice fisik (multi-photo upload), multi-item dalam satu invoice, dan pencatatan riwayat pengadaan.
- **📤 Transaksi Barang Keluar:** Pencatatan distribusi barang ke ruangan / penanggung jawab (PIC) dengan validasi ketersediaan stok secara otomatis.
- **📑 Laporan & Ekspor:** Laporan rekapitulasi data barang, pengadaan, dan barang keluar yang dapat difilter berdasarkan tanggal/kategori dan diekspor ke format **PDF** dan **Excel**.
- **🔐 Autentikasi & Multi-Role:** Pembagian hak akses antara **Admin** (akses penuh termasuk master data & backup database) dan **Operator** (operasional inventaris & transaksi).

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Tailwind CSS, Alpine.js, Chart.js, Blade Templating
- **Database:** SQLite / MySQL
- **Assets Bundler:** Vite

---

## 🚀 Panduan Instalasi & Menjalankan Lokal

### 1. Clone Repository
```bash
git clone https://github.com/faqihafivan/asetra.git
cd asetra
```

### 2. Install Dependensi PHP & JavaScript
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Generate application key:
```bash
php artisan key:generate
```

### 4. Setup Database & Seed Data Demo
Jalankan migrasi database beserta seeder awal:
```bash
php artisan migrate --seed
```

> **Kredensial Akun Bawaan (Demo):**
> - **Admin:** `admin@asetra.com` | Password: `password`
> - **Operator:** `operator@asetra.com` | Password: `password`

### 5. Compile Frontend Assets
```bash
npm run build
```

### 6. Jalankan Server Lokal
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

---

## 📄 Lisensi
Aplikasi ini dikembangkan untuk kebutuhan manajemen aset dan inventaris.
