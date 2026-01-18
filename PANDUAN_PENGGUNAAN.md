# PANDUAN PENGGUNAAN - Sistem Absen QR Code

## 📱 Flow Penggunaan QR Code

### Scenario 1: User Biasa (Peserta)

```
1. Scan QR Code dengan smartphone
2. Jika belum login:
   → Redirect ke halaman LOGIN
   → User login dengan akun mereka
3. Setelah login (User Biasa):
   → Tampilkan FORM PENGISIAN ABSEN
   → User isi data (nama, email, telepon, institusi)
   → Klik "Konfirmasi Absen"
   → Data tersimpan & sukses pesan ditampilkan
```

### Scenario 2: Admin (Pengelola)

```
1. Scan QR Code dengan smartphone
2. Jika belum login:
   → Redirect ke halaman LOGIN
   → Admin login dengan akun admin
3. Setelah login (Admin):
   → Redirect ke HALAMAN DAFTAR PESERTA (Session Detail)
   → Admin lihat siapa saja yang sudah hadir
   → Admin bisa export data kehadiran ke CSV
```

### Scenario 3: User Sudah Login Sebelumnya

```
1. Scan QR Code
2. User sudah login (Session masih aktif):
   → Langsung ke FORM ABSEN (jika user biasa)
   → Langsung ke DAFTAR PESERTA (jika admin)
```

---

## 🔑 User Demo (Sudah Tersedia)

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@example.com | password |
| **User** | user@example.com | password |

---

## 👨‍💻 Untuk Admin

### Membuat Sesi Absen

1. Login dengan **admin@example.com**
2. Klik **"Dashboard Admin"** (di navbar atau homepage)
3. Klik tombol **"Buat Sesi Baru"**
4. Isi form:
   - **Nama Sesi**: Misal "Acara Webinar 15 Januari 2026"
   - **Deskripsi**: Deskripsi event (optional)
   - **Tanggal Mulai**: Kapan sesi dimulai
   - **Tanggal Berakhir**: Kapan sesi selesai (optional)
5. Klik **"Buat Sesi"**
6. Sesi berhasil dibuat ✅

### Membagikan QR Code

1. Di halaman **"Daftar Sesi"**, cari sesi yang ingin dibagikan
2. Klik tombol **"QR Code"** (ikon QR Code)
3. Pilih salah satu:
   - **Cetak QR Code** - Print ke kertas
   - **Download** - Download gambar QR Code
   - **Salin Link** - Copy URL untuk dibagikan via chat/email

### Melihat Daftar Peserta yang Hadir

1. Di halaman **"Daftar Sesi"**, klik **"Lihat"** pada sesi yang ingin dicek
2. Tampil list peserta dengan kolom:
   - Nomor urut
   - Nama peserta
   - Email
   - No Telepon
   - Institusi
   - Jam hadir
3. Atau scan QR Code saat login sebagai admin → langsung ke halaman ini

### Export Data Kehadiran

1. Di halaman **"Daftar Sesi"**, klik tombol **"Download"** (ikon download)
2. File CSV akan terdownload otomatis
3. Buka di Excel/Google Sheets untuk analisis lebih lanjut

---

## 👤 Untuk Peserta (User Biasa)

### Cara Absen

1. **Buka QR Code** (dari WhatsApp, email, atau kertas)
2. **Scan dengan kamera smartphone**
   - Akan otomatis membuka browser
   - Link: `http://localhost:8000/absen/{TOKEN}`

3. **Jika belum login:**
   - Masuk halaman LOGIN
   - Login dengan email & password Anda
   - Atau daftar akun baru jika belum punya

4. **Setelah login:**
   - Tampil **FORM PENGISIAN ABSEN**
   - Nama sudah ter-isi otomatis dari akun Anda
   - Isi data tambahan (email, telepon, institusi)
   - Klik **"Konfirmasi Absen"**

5. **Sukses! ✅**
   - Muncul pesan "Absen berhasil!"
   - Data tersimpan di database

---

## ⚠️ Hal-Hal Penting

### Pembatasan Absen

- **Satu user hanya bisa absen 1 kali per sesi**
  - Jika coba absen lagi → Error "Anda sudah melakukan absen di sesi ini"

- **Admin TIDAK bisa melakukan absen**
  - Ketika admin scan QR Code → masuk ke halaman daftar peserta (bukan form absen)
  - Jika admin force POST ke form absen → Error "Admin tidak bisa melakukan absen"

- **Sesi dengan status expired tidak bisa digunakan**
  - Jika tanggal berakhir sudah lewat → Error "Session telah berakhir"

### Autentikasi

- QR Code scanning WAJIB login terlebih dahulu
- Jika belum login → redirect ke halaman LOGIN
- Session akan remember selama 2 jam (SESSION_LIFETIME di .env)

---

## 🔐 Keamanan

✅ **Fitur Keamanan yang Diterapkan:**

- Password di-hash menggunakan bcrypt
- CSRF protection pada semua form
- SQL injection protection (Eloquent ORM)
- Admin-only routes dilindungi middleware `admin`
- Unique constraint pada (session_id, user_id) di database
- Foreign key constraints untuk integritas data

---

## 📊 Data Attendance

### Struktur Data yang Tersimpan

Ketika peserta absen, sistem menyimpan:
- **ID Peserta** (user_id)
- **ID Sesi** (session_id)
- **Nama** (dari form)
- **Email** (dari form)
- **No Telepon** (dari form)
- **Institusi** (dari form)
- **Waktu Absen** (timestamp otomatis)
- **Created At** (waktu record dibuat)
- **Updated At** (waktu terakhir update)

### Export CSV Format

File CSV berisi kolom:
1. No (nomor urut)
2. Nama
3. Email
4. No Telepon
5. Institusi
6. Jam Hadir (YYYY-MM-DD HH:MM:SS)

---

## 🐛 Troubleshooting

### "Anda sudah melakukan absen di sesi ini"

**Solusi:** Peserta hanya bisa absen 1 kali per sesi. Jika ingin test, gunakan akun user berbeda atau admin untuk membuat sesi baru.

### "Admin tidak bisa melakukan absen"

**Solusi:** Ini by design. Admin hanya bisa lihat daftar peserta. Gunakan akun user biasa untuk tes form absen.

### QR Code tidak bisa discan

**Kemungkinan:**
- QR Code belum di-generate (klik tombol QR Code dulu)
- Smartphone camera tidak terfocus
- Coba copy paste URL langsung ke browser

### "Session telah berakhir"

**Solusi:** Sesi sudah melewati tanggal berakhir. Admin perlu buat sesi baru.

### Login gagal

**Kemungkinan:**
- Email/password salah
- User belum terdaftar
- Gunakan credentials demo: admin@example.com / password

---

## 📈 Tips Penggunaan

1. **Untuk Acara Besar:**
   - Print QR Code dan tempeli di pintu masuk/meja registrasi
   - Peserta scan saat tiba

2. **Untuk Acara Online:**
   - Share link di chat group / email
   - Peserta buka link, login, scan QR dari layar (bisa juga dari URL langsung)

3. **Untuk Tracking:**
   - Check halaman sesi secara real-time
   - Export data di akhir acara untuk record

4. **Untuk Multiple Peserta:**
   - Setiap peserta perlu akun terpisah
   - Atau admin bisa buat akun peserta sebelum event (via Tinker/Manual)

---

## 📞 Bantuan Lebih Lanjut

Jika ada masalah atau pertanyaan, check:
- README.md (panduan instalasi & setup)
- DOKUMENTASI_TEKNIS.md (dokumentasi developer)
- Log aplikasi di storage/logs/

Selamat menggunakan! 🎉
