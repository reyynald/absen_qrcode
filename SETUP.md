# 🚀 Quick Setup Guide

Ikuti langkah-langkah ini untuk menjalankan aplikasi Absen QR Code.

## ⚙️ Prasyarat

- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & NPM

## 📋 Langkah Setup

### 1. Konfigurasi Environment

```bash
# Copy .env file
cp .env.example .env

# Edit .env dan atur database
# DB_DATABASE=absen_qrcode
# DB_USERNAME=root
# DB_PASSWORD=(kosong atau password mysql Anda)
```

### 2. Install Dependencies

```bash
# PHP dependencies
composer install

# JavaScript dependencies
npm install
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Setup Database

```bash
# Jalankan migrations
php artisan migrate

# Jalankan seeders (buat user default)
php artisan db:seed
```

### 5. Build Assets

```bash
npm run build
```

### 6. Jalankan Server

```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## 👤 Login Credentials

Setelah setup, gunakan akun berikut:

### Admin Account
- **Email**: admin@example.com
- **Password**: password

### Regular User Account
- **Email**: user@example.com
- **Password**: password

## 🎯 Langkah Pertama Setelah Login

### Sebagai Admin:
1. Login dengan `admin@example.com`
2. Klik "Dashboard Admin" di menu
3. Klik "Buat Sesi Baru"
4. Isi data sesi (nama, deskripsi, tanggal)
5. Klik "Buat Sesi"
6. Di halaman detail sesi, klik tombol "QR Code"
7. QR Code dapat di-print atau di-share

### Sebagai User/Peserta:
1. Login dengan user biasa atau skip login
2. Scan QR Code dengan smartphone
3. Form pengisian akan muncul
4. Isi data pribadi (nama, email, dll)
5. Klik "Konfirmasi Absen"
6. Selesai! ✅

## 🔧 Development Mode

Untuk development dengan hot reload:

```bash
# Terminal 1: Run Laravel server
php artisan serve

# Terminal 2: Run Vite dev server
npm run dev
```

## 📦 Production Deployment

```bash
# Build production assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

## ❓ Troubleshooting

**Error: Database connection failed**
- Pastikan MySQL running
- Check `.env` database config
- Buat database manual jika diperlukan

**Error: SQLSTATE permission denied**
- Run migrations dengan `--force` flag
- Check database user permissions

**Error: Assets not loading (CSS/JS blank)**
- Run: `npm run build`
- Clear browser cache (Ctrl+Shift+Delete)
- Reload page

**Error: migration file not found**
- Pastikan sudah di directory yang benar
- Run: `php artisan migrate:fresh`

## 📞 Need Help?

Silakan check `README.md` untuk dokumentasi lengkap.

---

Happy coding! 🎉
