# 🎯 CARA TEST QR CODE FLOW - STEP BY STEP

## 📋 Ringkas Flow yang Diinginkan:

```
1. Scan QR Code → Link ke http://127.0.0.1:8000/absen/{TOKEN}
2. Jika belum login → TAMPIL LOGIN PAGE
3. Login → Redirect ke link QR Code asli (/absen/{TOKEN})
4. Jika user biasa → TAMPIL FORM ABSEN
5. Jika admin → TAMPIL DAFTAR PESERTA (attendance list)
```

---

## ✅ STEP 1: Buka Dashboard Admin

### Cara Login Admin:
1. **Buka**: http://127.0.0.1:8000
2. **Klik**: "Login" (atau di navbar)
3. **Email**: `admin@example.com`
4. **Password**: `password`
5. **Klik**: "Login"

**Atau langsung**: http://127.0.0.1:8000/dashboard

---

## ✅ STEP 2: Buat Session Absen Baru (Jika belum ada)

Jika sudah ada session, skip ke STEP 3.

1. **Di Dashboard Admin**, lihat di left sidebar atau top navbar
2. **Klik**: "Admin Dashboard" / "Dashboard Admin"
3. **Klik**: Tombol "Buat Sesi Baru" (Warna hijau/primary)
4. **Isi Form:**
   - **Nama**: "Test Absen QR Code"
   - **Deskripsi**: "Session untuk test QR Code flow"
   - **Tanggal Mulai**: 2026-01-15
   - **Tanggal Berakhir**: 2026-01-20
5. **Klik**: "Buat Sesi"
6. **Tunggu** → Akan redirect ke daftar sesi

---

## ✅ STEP 3: Generate QR Code

Sekarang Anda sudah punya session. Mari generate QR Code:

1. **Di halaman "Daftar Sesi"** (atau bisa klik "Sesi Absen" di sidebar)
2. **Cari sesi** yang baru dibuat → "Test Absen QR Code"
3. **Klik tombol** dengan icon QR Code (berbentuk kotak-kotak)
4. **Akan muncul halaman dengan:**
   - QR Code image (kotak-kotak besar)
   - URL di bawah: `http://127.0.0.1:8000/absen/{TOKEN_PANJANG}`
   - Tombol "Print" & "Download"

---

## ✅ STEP 4: TESTING FLOW (CARA 1 - LOGOUT DULU)

### Logout Admin terlebih dahulu:

1. **Klik Nama Admin** (top right) → Dropdown
2. **Klik**: "Logout"
3. **Sekarang Anda in "Not Logged In" state**

### Test: Akses QR Code sebagai User Tidak Login

1. **Buka halaman QR Code** (dari STEP 3)
   - Atau copy URL: `http://127.0.0.1:8000/absen/{TOKEN}`
   - Paste di address bar

2. **EXPECTED RESULT:**
   - ❌ JANGAN ke dashboard
   - ✅ HARUS redirect ke **LOGIN PAGE**
   - Anda harus lihat form login

3. **Login sebagai User Biasa:**
   - **Email**: `user@example.com`
   - **Password**: `password`

4. **SETELAH LOGIN:**
   - ✅ HARUS redirect ke `/absen/{TOKEN}` (URL QR Code)
   - ✅ HARUS tampil **FORM PENGISIAN ABSEN** (bukan dashboard!)
   - Form harus sudah pre-filled dengan nama user

5. **Isi Form:**
   - Email, Telepon, Institusi (boleh sembarang)
   - Klik "Konfirmasi Absen"

6. **EXPECTED RESULT:**
   - ✅ Success message: "Absen berhasil!"
   - ✅ Redirect ke homepage atau show success page

---

## ✅ STEP 5: TEST ADMIN FLOW (CARA 2)

### Logout User, Login as Admin lagi:

1. **Logout user** (profile dropdown → logout)
2. **Buka URL QR Code** lagi: `http://127.0.0.1:8000/absen/{TOKEN}`
3. **Login dengan Admin:**
   - **Email**: `admin@example.com`
   - **Password**: `password`

4. **AFTER LOGIN:**
   - ✅ HARUS redirect ke halaman daftar peserta (attendance list)
   - ✅ BUKAN form absen!
   - Akan lihat table dengan peserta yang sudah absen (user dari STEP 4)

5. **Admin bisa:**
   - Lihat siapa saja yang sudah hadir
   - Export CSV
   - Delete session

---

## ✅ STEP 6: VERIFIKASI DI DATABASE

### Check attendance record tersimpan:

Buka MySQL / database client dan run query:

```sql
-- Lihat sessions
SELECT id, name, qr_code_token FROM attendance_sessions;

-- Lihat attendance records
SELECT * FROM attendance;

-- Lihat detail attendance untuk session tertentu
SELECT a.*, s.name as session_name 
FROM attendance a 
JOIN attendance_sessions s ON a.session_id = s.id 
ORDER BY a.created_at DESC;
```

---

## 🎯 EXPECTED BEHAVIOR CHECKLIST

- [ ] Scan/Buka QR Code tanpa login → **Redirect ke LOGIN PAGE**
- [ ] Login as User → **Redirect ke FORM ABSEN**
- [ ] Form absen pre-filled dengan nama user ✓
- [ ] Submit form → **Success message & data tersimpan**
- [ ] Logout & Scan QR Code lagi sebagai Admin → **Redirect ke ATTENDANCE LIST** (bukan form)
- [ ] Admin melihat user yang sudah absen di table
- [ ] Query database → Data attendance tersimpan dengan session_id & user_id

---

## 🔴 Jika ADA MASALAH:

### ❌ Langsung ke dashboard saat scan QR (tidak minta login):
- **Penyebab**: Auth middleware tidak bekerja
- **Check**: Routes di `routes/web.php` pastikan `/absen/{token}` punya `middleware('auth')`

### ❌ Login berhasil tapi tidak redirect ke QR link:
- **Penyebab**: `redirect()->intended()` tidak bekerja
- **Check**: AuthenticatedSessionController di `app/Http/Controllers/Auth/`

### ❌ Admin login tapi masuk ke form absen (bukan attendance list):
- **Penyebab**: `handleQRCode()` method di AttendanceController tidak check is_admin
- **Check**: Method `handleQRCode()` di `app/Http/Controllers/AttendanceController.php`

### ❌ Form tidak pre-filled dengan nama user:
- **Penyebab**: Form tidak akses auth()->user()->name
- **Check**: `resources/views/attendance/form.blade.php` line dengan `{{ auth()->user()->name }}`

---

## 📱 QUICK QR CODE TEST:

### Jika Anda ingin LANGSUNG test tanpa create session baru:

1. **Anggap Anda sudah punya QR Code URL**: `http://127.0.0.1:8000/absen/abc123def`
2. **Logout dari semua akun**
3. **Copy-paste URL di browser**
4. **Klik Enter**
5. **Harusnya redirect ke `/login`**
6. **Login dengan user@example.com / password**
7. **Harusnya redirect balik ke `/absen/abc123def` dan tampil form**

---

## 🚀 RINGKAS: QR CODE URL FORMAT

```
http://127.0.0.1:8000/absen/{QR_CODE_TOKEN}
```

Dimana `{QR_CODE_TOKEN}` adalah:
- Generated otomatis saat buat session
- Format: md5 hash (contoh: `5a8b3c4d9e1f2b3c4d5e6f7a8b9c0d1e`)
- Bersifat UNIQUE per session
- Disimpan di tabel `attendance_sessions` kolom `qr_code_token`

---

Sekarang coba follow step-by-step di atas dan report hasilnya! 🎉
