# 🎯 FLOW APLIKASI YANG BARU (ROMBAK ULANG)

## ✅ PERUBAHAN YANG DILAKUKAN:

### 1. **Root URL (/) → Langsung ke Login**
   - Sebelumnya: Akses "/" menampilkan welcome page
   - Sekarang: "/" di-redirect langsung ke "/login"
   - User **HARUS** login terlebih dahulu

### 2. **Role-Based Dashboard**
   - Setelah login, system akan check role user (`is_admin`)
   - **Jika Admin** → Redirect ke `/admin/dashboard` (Admin Dashboard)
   - **Jika User** → Redirect ke `/dashboard` (User Dashboard)

### 3. **Dashboard Peserta (User)**
   - Menampilkan welcome message
   - Panduan cara melakukan absen
   - Fitur yang tersedia untuk peserta
   - Link untuk scan QR Code

### 4. **Dashboard Admin**
   - Kelola sesi absen (CRUD)
   - Generate QR Code untuk setiap sesi
   - Lihat daftar peserta yang hadir
   - Export data kehadiran ke CSV

---

## 📱 DEMO CREDENTIALS (SUDAH UPDATE):

```
═══════════════════════════════════════════════════════════
👨‍💼 ADMIN
═══════════════════════════════════════════════════════════
Email    : admin@example.com
Password : admin123
Role     : Administrator
Dashboard: /admin/dashboard
```

```
═══════════════════════════════════════════════════════════
👤 USER / PESERTA
═══════════════════════════════════════════════════════════
Email    : user@example.com
Password : user123
Role     : Peserta Biasa
Dashboard: /dashboard

(Ada juga user kedua: peserta@example.com / peserta123)
```

---

## 🚀 FLOW PENGGUNAAN:

### **STEP 1: Buka Website**
```
1. Buka http://127.0.0.1:8000
2. System akan REDIRECT ke /login
3. Tampil halaman LOGIN
```

### **STEP 2: Login sebagai Admin**
```
1. Email: admin@example.com
2. Password: admin123
3. Klik "Login"
4. REDIRECT ke /admin/dashboard (Dashboard Admin)
```

### **STEP 3: Buat Sesi Absen (Admin)**
```
1. Di Admin Dashboard, klik "Buat Sesi Baru"
2. Isi form:
   - Nama Sesi: "Meeting 15 Januari 2026"
   - Deskripsi: (optional)
   - Tanggal Mulai & Berakhir
3. Klik "Buat Sesi"
```

### **STEP 4: Generate QR Code (Admin)**
```
1. Di halaman daftar sesi, klik icon QR Code
2. Akan tampil QR Code image
3. Lihat URL di bawah: http://127.0.0.1:8000/absen/{TOKEN}
4. Bagikan QR Code ke peserta (print atau screenshot)
```

### **STEP 5: Peserta Login & Absen**
```
1. Peserta buka/scan QR Code
2. Jika belum login:
   - Redirect ke /login
   - Peserta login dengan email & password
   - REDIRECT kembali ke URL QR Code
3. Tampil Form Pengisian Absen
4. Isi data dan klik "Konfirmasi Absen"
5. Data tersimpan! ✅
```

### **STEP 6: Admin Lihat Daftar Peserta (Admin)**
```
1. Di Admin Dashboard, klik "Lihat" pada sesi
2. Tampil tabel peserta yang sudah absen
3. Admin bisa export ke CSV
```

### **STEP 7: Logout**
```
1. Klik nama user di top right
2. Pilih "Logout"
3. REDIRECT ke /login (bukan welcome page)
```

---

## 🔄 RINGKAS FLOW DIAGRAM:

```
┌─────────────────────────────────────────────────────────────┐
│ User akses http://127.0.0.1:8000                           │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
         ┌───────────────────────────┐
         │ REDIRECT ke /login        │
         └────────────┬──────────────┘
                      │
          ┌───────────┴───────────┐
          │                       │
          ▼                       ▼
    ┌─────────────┐        ┌──────────────┐
    │  Login Page │        │  Sudah Login?│
    └──────┬──────┘        └──────────────┘
           │                      │
           │                      ├─ Admin?  → /admin/dashboard
           │                      │
           │                      └─ User?   → /dashboard
           │
     ┌─────▼────────────────────────────────┐
     │ Input Email & Password                │
     │ admin@example.com / admin123          │
     │ user@example.com / user123            │
     └─────┬────────────────────────────────┘
           │
           ▼
    ┌──────────────────────────┐
    │ Check is_admin field     │
    │ (true/false)             │
    └──────┬─────────────┬──────┘
           │             │
        YES│             │NO
           │             │
           ▼             ▼
    ┌─────────────┐  ┌──────────────┐
    │   ADMIN     │  │   USER       │
    │ Dashboard   │  │ Dashboard    │
    │  /admin/    │  │ /dashboard   │
    │ dashboard   │  └──────────────┘
    └─────────────┘        │
           │               │
           ▼               │
    ┌──────────────┐       │
    │ Manage       │       │
    │ Sessions &   │       │
    │ Generate QR  │       │
    └──────────────┘       │
                           │
           ┌───────────────┘
           │
           ▼
    ┌──────────────────────┐
    │ Scan QR Code         │
    │ /absen/{TOKEN}       │
    └──────┬───────────────┘
           │
           ▼
    ┌──────────────────────┐
    │ Form Absen           │
    │ (pre-filled name)    │
    └──────┬───────────────┘
           │
           ▼
    ┌──────────────────────┐
    │ Submit & Save        │
    │ ✅ Absen Berhasil!   │
    └──────────────────────┘
```

---

## 🎯 TESTING CHECKLIST:

- [ ] Buka http://127.0.0.1:8000 → Redirect ke /login
- [ ] Login admin → Redirect ke /admin/dashboard
- [ ] Login user → Redirect ke /dashboard
- [ ] Admin buat session → Session tersimpan
- [ ] Admin generate QR Code → QR Code muncul
- [ ] Logout → Redirect ke /login (bukan welcome)
- [ ] Peserta scan QR tanpa login → Tampil login page
- [ ] Peserta login → Redirect balik ke QR link
- [ ] Peserta isi form & submit → Data tersimpan

---

## 📝 CATATAN PENTING:

1. **Database sudah fresh + seed**
   - Semua user sudah dibuat otomatis
   - Tidak perlu daftar manual

2. **Credentials sudah dalam comment di login page**
   - User bisa lihat demo credentials saat login

3. **Session attendance**
   - QR Code token unique per session
   - Peserta hanya bisa absen 1x per sesi

4. **Admin special features**
   - Jika admin scan QR → Masuk ke attendance list (bukan form)
   - Admin tidak bisa melakukan absen

---

Sekarang coba akses http://127.0.0.1:8000 dan test flow baru! 🚀
