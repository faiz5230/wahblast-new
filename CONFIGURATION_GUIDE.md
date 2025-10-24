# ⚙️ Configuration Guide - WhatsApp Blast

## 🔧 Environment Variables (.env)

### WhatsApp Server Configuration

Saya telah menambahkan konfigurasi WhatsApp Server ke file `.env`:

```env
# WhatsApp Server Configuration
URL_WA_SERVER=http://127.0.0.1:3000
```

**Penting:** Variabel ini digunakan oleh Laravel untuk berkomunikasi dengan WhatsApp Server (Node.js).

---

## 🌐 Default Ports & URLs

| Service | Port | URL | Fungsi |
|---------|------|-----|--------|
| **Laravel Server** | 8000 | http://127.0.0.1:8000 | Web Application (Admin Panel) |
| **WhatsApp Server** | 3000 | http://127.0.0.1:3000 | WhatsApp API (Baileys) |

---

## 📝 Langkah Setup Lengkap

### 1. **Konfigurasi Database**

Edit file `.env` dan sesuaikan dengan database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wablast
DB_USERNAME=root
DB_PASSWORD=
```

**Pastikan:**
- Database `wablast` sudah dibuat
- MySQL/MariaDB sudah berjalan
- Username dan password sudah benar

### 2. **Konfigurasi WhatsApp Server**

Pastikan URL WhatsApp Server sudah benar di `.env`:

```env
URL_WA_SERVER=http://127.0.0.1:3000
```

**Catatan:** Jika Anda mengubah port WhatsApp Server di `anywhatzap/anywhatzap/app.js`, update juga di sini!

### 3. **Generate APP_KEY** (Sudah dilakukan!)

```bash
php artisan key:generate
```

✅ APP_KEY sudah di-generate: `base64:dmIh2xOUtP3QbCebHXyNd0zg8ri5xPDvQw0DhjZqp5w=`

### 4. **Run Migrations**

```bash
php artisan migrate
```

Ini akan membuat semua tabel yang diperlukan di database.

### 5. **Clear All Caches**

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

✅ Sudah dilakukan!

---

## 🚀 Menjalankan Aplikasi

### Option 1: Menggunakan BAT Files (RECOMMENDED)

```bash
# Jalankan kedua server sekaligus
start-both-servers.bat
```

### Option 2: Manual

**Terminal 1 - WhatsApp Server:**
```bash
cd anywhatzap/anywhatzap
node app.js
```

**Terminal 2 - Laravel Server:**
```bash
php artisan serve
```

---

## 🔍 Testing Koneksi

### 1. Test WhatsApp Server
Buka browser: http://127.0.0.1:3000

Atau test dengan curl:
```bash
curl http://127.0.0.1:3000
```

### 2. Test Laravel Server
Buka browser: http://127.0.0.1:8000

### 3. Test Laravel → WhatsApp Connection
1. Login ke Laravel admin panel: http://127.0.0.1:8000
2. Pergi ke menu Device
3. Click tombol "Scan"
4. Seharusnya muncul QR Code (tidak error lagi!)

---

## ⚠️ Troubleshooting

### Error: "Could not resolve host: connect"

**Penyebab:** `URL_WA_SERVER` tidak di-set atau salah di `.env`

**Solusi:**
1. ✅ Sudah diperbaiki! `URL_WA_SERVER` sudah ditambahkan
2. Pastikan WhatsApp Server berjalan di port 3000
3. Clear config cache: `php artisan config:clear`
4. Restart Laravel server

### Error: "Connection refused"

**Penyebab:** WhatsApp Server tidak berjalan

**Solusi:**
1. Jalankan WhatsApp Server terlebih dahulu
2. Gunakan `start-both-servers.bat` untuk otomatis
3. Atau manual: `cd anywhatzap/anywhatzap && node app.js`

### Error: "Port 3000 already in use"

**Penyebab:** Ada aplikasi lain menggunakan port 3000

**Solusi 1 - Stop aplikasi lain:**
```bash
# Windows
netstat -ano | findstr :3000
taskkill /PID <PID> /F
```

**Solusi 2 - Ubah port WhatsApp Server:**
1. Edit `anywhatzap/anywhatzap/app.js` (jika tidak ter-obfuscate)
2. Atau buat file `.env` di folder `anywhatzap/anywhatzap/`
3. Update `URL_WA_SERVER` di Laravel `.env` sesuai port baru

### Error: QR Code tidak muncul

**Penyebab:** WhatsApp Server belum siap atau error

**Solusi:**
1. Cek log WhatsApp Server di terminal
2. Pastikan folder `anywhatzap/anywhatzap/auth_info_baileys` ada
3. Hapus folder tersebut jika corrupt, lalu restart
4. Install ulang dependencies: `cd anywhatzap/anywhatzap && npm install`

---

## 📊 Environment Variables Lengkap

Berikut daftar lengkap environment variables di `.env`:

```env
# Application
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:dmIh2xOUtP3QbCebHXyNd0zg8ri5xPDvQw0DhjZqp5w=
APP_DEBUG=true
APP_URL=http://localhost

# WhatsApp Server Configuration (BARU!)
URL_WA_SERVER=http://127.0.0.1:3000

# Logging
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wablast
DB_USERNAME=root
DB_PASSWORD=

# Cache & Session
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Redis (Optional)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail (Optional)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🔐 Security Notes

1. **Jangan commit `.env` ke Git!** ✅ Sudah ada di `.gitignore`
2. **APP_KEY harus unik** untuk setiap instalasi
3. **APP_DEBUG=false** di production
4. **Ganti database password** di production
5. **URL_WA_SERVER** harus menggunakan HTTPS di production

---

## 📝 Checklist Setup

- [x] ✅ File `.env` sudah ada
- [x] ✅ APP_KEY sudah di-generate
- [x] ✅ URL_WA_SERVER sudah di-set
- [ ] ⏳ Database sudah dibuat
- [ ] ⏳ Migrations sudah dijalankan
- [ ] ⏳ WhatsApp Server dependencies terinstall
- [ ] ⏳ Laravel dependencies terinstall
- [ ] ⏳ Kedua server berjalan
- [ ] ⏳ QR Code sudah di-scan

---

## 🆘 Support

Jika masih ada masalah:
1. Pastikan semua checklist di atas sudah ✅
2. Cek log Laravel di `storage/logs/laravel.log`
3. Cek log WhatsApp Server di terminal
4. Baca dokumentasi:
   - `PHP_8.4_UPGRADE_GUIDE.md`
   - `LARAVEL_11_MIGRATION_NOTES.md`
   - `BAT_FILES_GUIDE.md`

---

**Configuration Complete!** 🎉
Silakan test ulang tombol "Scan" di admin panel.
