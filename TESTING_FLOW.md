# 📋 CARA TESTING APLIKASI ABSEN QR CODE

## ✅ FLOW YANG SUDAH BERFUNGSI:

### **1️⃣ SCENARIO: User Baru (Belum Punya Akun)**

```
STEP 1: Scan QR Code / Akses /absen/{token}
   ↓
STEP 2: Redirect ke halaman LOGIN (karena belum login)
   ↓
STEP 3: Klik "Daftar di sini" → Halaman REGISTER
   ↓
STEP 4: Isi form daftar:
   - Nama Lengkap
   - Email
   - Password
   - Konfirmasi Password
   ↓
STEP 5: Klik "Daftar"
   ↓
STEP 6: Redirect ke LOGIN PAGE dengan pesan: "Akun berhasil dibuat!"
   ↓
STEP 7: Login dengan akun baru:
   - Email: (yang baru didaftarkan)
   - Password: (yang baru dibuat)
   ↓
STEP 8: ✅ OTOMATIS REDIRECT KE FORM PENGISIAN ABSEN
   ↓
STEP 9: Isi form absen:
   - Nama Lengkap: (auto-filled dari akun)
   - Email: (auto-filled)
   - No. Telepon: (isi atau skip)
   - Institusi: (isi atau skip)
   - Jurusan/Divisi: (isi atau skip)
   - Jam Datang: (REQUIRED - isi jam, contoh: 08:30)
   - Jam Pulang: (optional - isi atau skip)
   ↓
STEP 10: Klik "Konfirmasi Absen"
   ↓
STEP 11: ✅ REDIRECT KE DASHBOARD dengan pesan:
   "✅ Terima kasih telah mengisi form absen! Data Anda telah tersimpan."
```

---

### **2️⃣ SCENARIO: User Sudah Punya Akun**

```
STEP 1: Scan QR Code / Akses /absen/{token}
   ↓
STEP 2: Redirect ke LOGIN PAGE (karena belum login)
   ↓
STEP 3: Login dengan akun yang sudah ada:
   - Email: (sudah terdaftar)
   - Password: (password akun)
   ↓
STEP 4: ✅ OTOMATIS REDIRECT KE FORM PENGISIAN ABSEN
   ↓
STEP 5-11: (Sama seperti scenario 1)
```

---

### **3️⃣ SCENARIO: Admin Cek Data Absen**

```
STEP 1: Login sebagai Admin
   - Email: admin@example.com
   - Password: admin123
   ↓
STEP 2: Redirect ke ADMIN DASHBOARD
   ↓
STEP 3: Klik "Sesi Absen" di sidebar / menu
   ↓
STEP 4: Akan tampil daftar semua sessions
   ↓
STEP 5: Klik tombol "Lihat" pada session yang ingin dicek
   ↓
STEP 6: ✅ TAMPIL TABEL DAFTAR PESERTA dengan kolom:
   - No
   - Nama
   - Email
   - No Telepon
   - Institusi
   - Jurusan (yang baru isi tadi)
   - Jam Datang (yang baru isi tadi)
   - Jam Pulang (yang baru isi tadi)
   - Waktu Absen
   ↓
STEP 7: Admin bisa:
   - CETAK: Klik "Cetak" untuk print data
   - DOWNLOAD: Klik "Download" untuk export CSV
   - BACK: Klik "Kembali" untuk kembali ke daftar sessions
```

---

## 📝 DEMO CREDENTIALS

```
┌─────────────────────────────────────────┐
│ ADMIN                                   │
├─────────────────────────────────────────┤
│ Email    : admin@example.com            │
│ Password : admin123                     │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│ USER (Demo)                             │
├─────────────────────────────────────────┤
│ Email    : user@example.com             │
│ Password : user123                      │
└─────────────────────────────────────────┘

┌─────────────────────────────────────────┐
│ USER (Demo 2)                           │
├─────────────────────────────────────────┤
│ Email    : peserta@example.com          │
│ Password : peserta123                   │
└─────────────────────────────────────────┘
```

---

## 🎯 TESTING CHECKLIST

### **User Baru Registration:**
- [ ] Bisa scan QR → redirect ke login ✓
- [ ] Bisa register akun baru ✓
- [ ] Setelah register → redirect ke login (bukan auto login) ✓
- [ ] Success message muncul: "Akun berhasil dibuat!" ✓
- [ ] Bisa login dengan akun baru ✓
- [ ] Setelah login → redirect ke form absen ✓
- [ ] Form absen bisa di-isi ✓
- [ ] Setelah submit → muncul pesan "Terima kasih..." ✓

### **Data Tersimpan:**
- [ ] Nama tersimpan ✓
- [ ] Email tersimpan ✓
- [ ] No Telepon tersimpan (jika diisi) ✓
- [ ] Institusi tersimpan (jika diisi) ✓
- [ ] **Jurusan tersimpan (jika diisi)** ✅
- [ ] **Jam Datang tersimpan** ✅
- [ ] **Jam Pulang tersimpan (jika diisi)** ✅

### **Admin Dashboard:**
- [ ] Admin bisa lihat tabel peserta ✓
- [ ] Semua kolom tampil dengan benar ✓
- [ ] Data jurusan tampil atau "-" jika kosong ✓
- [ ] Data jam datang tampil dengan badge hijau ✓
- [ ] Data jam pulang tampil dengan badge merah atau "-" ✓
- [ ] Bisa export CSV ✓
- [ ] Bisa print ✓

---

## 🔧 TROUBLESHOOTING

### **Masalah: Form absen tidak muncul setelah login**
**Solusi:**
1. Pastikan URL QR Code mengandung `{token}` yang valid
2. Cek database apakah session dengan token tersebut ada
3. Refresh browser (F5)

### **Masalah: Data jurusan, jam datang, jam pulang tidak tersimpan**
**Solusi:**
1. ✅ Pastikan Model Attendance sudah di-update dengan fillable baru
2. ✅ Pastikan migration sudah jalan: `php artisan migrate --step`
3. Refresh browser dan test ulang dengan data baru

### **Masalah: Data tidak muncul di admin dashboard**
**Solusi:**
1. Pastikan sudah login sebagai admin
2. Pastikan data yang diisi user adalah untuk session yang sama yang admin lihat
3. Refresh browser (F5) untuk refresh data

### **Masalah: Jam datang/pulang tampil error**
**Solusi:**
1. Pastikan format jam benar: HH:MM (contoh: 08:30, 17:45)
2. Browser harus support HTML5 time input
3. Coba gunakan browser terbaru (Chrome, Firefox, Edge)

---

## 📲 URL PENTING

```
Home/Login       : http://127.0.0.1:8000/
Register         : http://127.0.0.1:8000/register
User Dashboard   : http://127.0.0.1:8000/dashboard
Admin Dashboard  : http://127.0.0.1:8000/admin/dashboard
Admin Sessions   : http://127.0.0.1:8000/admin/sessions
QR Code Scan     : http://127.0.0.1:8000/absen/{token}
```

---

## 🚀 QUICK TEST

**Paling cepat untuk test:**

1. Login dengan `user@example.com / user123`
2. Pergi ke `/absen/{any-token}` (contoh: `/absen/test123`)
3. Isi form absen dengan data lengkap
4. Submit
5. Seharusnya muncul pesan "Terima kasih..."

**Untuk verify data di admin:**

1. Login dengan `admin@example.com / admin123`
2. Pergi ke `/admin/sessions`
3. Klik "Lihat" pada session apapun
4. Seharusnya bisa lihat data yang baru diisi (jika user ada di session itu)

---

Semoga lancar! 🎉
