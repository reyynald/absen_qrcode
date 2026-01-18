# Dokumentasi Teknis Sistem Absen QR Code

## 📌 Ringkas Overview

Sistem ini dibangun menggunakan:
- **Backend**: Laravel 12 (PHP Framework)
- **Frontend**: Bootstrap 5 + Blade Template Engine
- **Database**: MySQL 8.0
- **Authentication**: Laravel Breeze (built-in authentication)
- **QR Code**: QRCode.js library

## 🏗️ Arsitektur Aplikasi

### Controller Layer

#### AttendanceController
Menangani:
- `showForm($token)` - Tampilkan form absen berdasarkan token QR Code
- `store(Request $request, $token)` - Simpan data absen dan validasi

#### AdminController
Menangani:
- Dashboard admin dengan statistik
- CRUD sesi absen
- Generate QR Code
- Export data kehadiran ke CSV

### Model Layer

#### User
```php
// Hubungan
- hasMany(Attendance) // Peserta yang terdaftar
- hasMany(AttendanceSession) // Sesi yang dibuat
```

#### AttendanceSession
```php
// Hubungan
- belongsTo(User, 'created_by') // Pembuat sesi
- hasMany(Attendance) // Data kehadiran dalam sesi ini

// Methods
- generateQRCodeToken() // Generate token unik untuk QR Code
```

#### Attendance
```php
// Hubungan
- belongsTo(AttendanceSession, 'session_id') // Sesi absen
- belongsTo(User) // Peserta yang hadir
```

### Route Structure

```
/ (home page)
/login, /register (authentication routes)
/dashboard (user dashboard)

/absen/{token} (GET - show form, POST - store data)

/admin/ (middleware: auth, verified, admin)
├── /dashboard (statistik)
├── /sessions (list semua sesi)
├── /sessions/create (form buat sesi)
├── /sessions/{id} (detail sesi + list peserta)
├── /sessions/{id}/qrcode (tampilkan QR Code)
├── /sessions/{id}/export (export CSV)
└── /sessions/{id} (DELETE - hapus sesi)
```

## 🔑 Middleware & Authorization

### IsAdmin Middleware
Melindungi route admin dengan memeriksa:
1. User sudah terautentikasi
2. User memiliki `is_admin = true` di database

### Route Protection
```php
// Protected routes
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Admin only routes
});

// Public routes
Route::get('/absen/{token}', ...); // Bisa diakses siapa saja
```

## 💾 Database Operations

### Attendance Session Creation
```php
1. User admin membuat sesi
2. Token QR Code dihasilkan: md5(uniqid() + time())
3. Sesi disimpan dengan created_by = user id
4. QR Code berisi: /absen/{token}
```

### Attendance Recording
```php
1. Peserta scan QR Code → /absen/{token}
2. Form ditampilkan dengan session info
3. Peserta isi form (nama, email, phone, institution)
4. Validasi:
   - Nama (required)
   - Email (email format, unique per session)
   - Phone & Institution (optional)
5. Cek duplikasi dengan unique constraint pada (session_id, user_id)
6. Simpan dengan timestamp checked_in_at
```

## 🔐 Security Features

### Input Validation
```php
// AttendanceController validation
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'nullable|email|max:255',
    'phone' => 'nullable|string|max:20',
    'institution' => 'nullable|string|max:255',
]);
```

### CSRF Protection
Semua form menggunakan `@csrf` directive

### Query Protection
- Menggunakan Eloquent ORM (prepared statements)
- Tidak ada raw SQL queries

### Authorization
- Admin check di middleware
- Foreign key constraints di database
- Can't modify sessions yang bukan dibuat user

## 📦 Dependencies

### Composer (PHP)
```json
{
    "laravel/framework": "^12.0",
    "laravel/tinker": "^2.10.1",
    "laravel/breeze": "^2.3" (untuk auth)
}
```

### NPM (JavaScript)
```json
{
    "qrcode": "^1.5.3" (untuk generate QR Code)
    "bootstrap": "^5.3.0"
}
```

## 🧪 Testing Commands

```bash
# Generate fresh migration & seed
php artisan migrate:fresh --seed

# Create admin user
php artisan tinker
>>> App\Models\User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => Hash::make('password'), 'is_admin' => true])

# Generate key
php artisan key:generate

# Clear cache
php artisan cache:clear
php artisan config:clear
```

## 📂 File Penting & Lokasi

| File | Fungsi |
|------|--------|
| `routes/web.php` | Route definitions |
| `app/Http/Controllers/AttendanceController.php` | Logic absen |
| `app/Http/Controllers/AdminController.php` | Logic admin |
| `app/Http/Middleware/IsAdmin.php` | Admin authorization |
| `app/Models/AttendanceSession.php` | Model sesi |
| `app/Models/Attendance.php` | Model kehadiran |
| `bootstrap/app.php` | Middleware registration |
| `database/migrations/*` | Schema definitions |
| `resources/views/attendance/form.blade.php` | Form absen |
| `resources/views/admin/sessions/` | Admin pages |

## 🚀 Deployment Tips

1. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

2. **Database Setup**
   ```bash
   php artisan migrate --force
   php artisan db:seed
   ```

3. **Cache & Optimization**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

4. **Assets Build**
   ```bash
   npm install
   npm run build
   ```

5. **Permissions**
   ```bash
   chmod -R 775 storage/
   chmod -R 775 bootstrap/cache/
   ```

## 📊 Performance Optimization

### Database Indexes
```sql
-- Otomatis dari migration
- PRIMARY KEY pada id
- FOREIGN KEYs pada session_id, user_id, created_by
- UNIQUE pada qr_code_token
- UNIQUE pada (session_id, user_id)
```

### Query Optimization
- Menggunakan eager loading: `with('attendances', 'creator')`
- Pagination untuk list data besar (15-20 items per page)

### Frontend Optimization
- CSS & JS di-minify otomatis oleh Vite
- Responsive design dengan Bootstrap grid
- Icons dari Bootstrap Icons (ringan)

## 🐛 Troubleshooting

### Database Connection Error
- Cek konfigurasi `.env` file
- Pastikan MySQL service running
- Pastikan database sudah dibuat

### Migration Error
- Clear cached configuration: `php artisan config:clear`
- Rollback dan migrate ulang: `php artisan migrate:fresh`

### Assets Not Loading
- Run: `npm run build`
- Clear browser cache (Ctrl+Shift+Delete)

### Admin Access Denied
- Check user `is_admin` column = 1
- Run seeder ulang: `php artisan db:seed`

## 📞 Kontribusi & Support

Feel free untuk modifikasi dan improve sesuai kebutuhan project!
