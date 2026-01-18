# Sistem Absen QR Code

Aplikasi modern untuk pencatatan kehadiran menggunakan QR Code berbasis Laravel 12.

## 🎯 Fitur Utama

- **QR Code Generation**: Buat QR Code unik untuk setiap sesi absen
- **Form Pengisian**: Form yang user-friendly untuk pengisian data absen
- **Admin Dashboard**: Dashboard lengkap untuk mengelola sesi dan melihat data kehadiran
- **Export Data**: Ekspor data kehadiran ke format CSV
- **Authentication**: Sistem login dengan pemisahan role admin dan user
- **Responsive Design**: Interface yang responsif dan modern dengan Bootstrap 5

## 📋 Persyaratan

- PHP 8.2 atau lebih tinggi
- Composer
- MySQL 5.7 atau lebih tinggi
- Node.js dan NPM

## 🚀 Instalasi

1. Clone repository atau download project
2. Salin file `.env.example` ke `.env`:
   ```bash
   cp .env.example .env
   ```

3. Generate application key:
   ```bash
   php artisan key:generate
   ```

4. Konfigurasi database di file `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=absen_qrcode
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Jalankan migrasi:
   ```bash
   php artisan migrate
   ```

6. Jalankan seeder untuk membuat user default:
   ```bash
   php artisan db:seed
   ```

7. Install NPM dependencies dan build assets:
   ```bash
   npm install
   npm run build
   ```

8. Jalankan development server:
   ```bash
   php artisan serve
   ```

Aplikasi akan berjalan di `http://localhost:8000`

## 👤 User Default

Setelah menjalankan seeder, berikut user yang sudah terbuat:

**Admin User:**
- Email: `admin@example.com`
- Password: `password`

**Regular User:**
- Email: `user@example.com`
- Password: `password`

## 📝 Panduan Penggunaan

### Untuk Admin

1. Login dengan email admin@example.com
2. Akses Dashboard Admin dari menu navbar
3. Buat sesi absen baru dengan klik "Buat Sesi Baru"
4. Isi detail sesi (nama, deskripsi, tanggal)
5. Setelah sesi dibuat, klik tombol QR Code untuk melihat QR Code
6. QR Code dapat di-print atau di-share kepada peserta
7. Setelah peserta melakukan absen, lihat detail di halaman sesi
8. Export data kehadiran dalam format CSV

### Untuk Peserta

1. Scan QR Code dengan smartphone
2. Isi form dengan data pribadi (nama, email, no. telepon, institusi)
3. Klik "Konfirmasi Absen" untuk menyelesaikan
4. Peserta hanya bisa absen sekali per sesi

## 🗂️ Struktur Direktori Penting

```
absen_qrcode/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AttendanceController.php  (Controller absen)
│   │   │   ├── AdminController.php       (Controller admin)
│   │   │   └── Auth/                     (Auth controllers)
│   │   └── Middleware/
│   │       └── IsAdmin.php               (Admin middleware)
│   └── Models/
│       ├── User.php
│       ├── AttendanceSession.php
│       └── Attendance.php
├── database/
│   ├── migrations/                       (File migrasi)
│   └── seeders/
│       └── UserSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php             (Master layout)
│       │   └── navbar.blade.php
│       ├── attendance/
│       │   └── form.blade.php            (Form absen)
│       └── admin/
│           └── sessions/                 (Admin pages)
├── routes/
│   ├── web.php                           (Web routes)
│   └── auth.php                          (Auth routes)
└── public/
    └── build/                            (Assets)
```

## 📊 Database Schema

### Users Table
- id
- name
- email
- password
- is_admin (boolean)
- email_verified_at
- created_at
- updated_at

### Attendance Sessions Table
- id
- name
- description
- start_date
- end_date
- qr_code_token (unique)
- created_by (foreign key ke users)
- created_at
- updated_at

### Attendance Table
- id
- session_id (foreign key)
- user_id (foreign key)
- name
- email
- phone
- institution
- checked_in_at (timestamp)
- created_at
- updated_at

## 🔒 Keamanan

- Password di-hash menggunakan bcrypt
- Admin middleware untuk proteksi halaman admin
- CSRF protection pada semua form
- SQL injection protection melalui prepared statements

## 🎨 Customization

### Mengubah Warna Tema

Edit file `resources/views/layouts/app.blade.php`, ubah CSS variables:

```css
:root {
    --primary-color: #4f46e5;      /* Warna utama */
    --secondary-color: #10b981;    /* Warna sekunder */
    --danger-color: #ef4444;       /* Warna danger */
}
```

### Mengubah Data User

Silakan modify file `database/seeders/UserSeeder.php`

## 📞 Support

Untuk pertanyaan atau masalah, silakan buat issue atau hubungi developer.

## 📄 License

MIT License. Silakan gunakan secara bebas untuk project pribadi maupun komersial.


Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
