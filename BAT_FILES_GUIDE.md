# 📁 Panduan File BAT untuk WhatsApp Blast

## 📋 Daftar File BAT yang Tersedia

Saya telah membuat 5 file .bat untuk mempermudah menjalankan aplikasi:

### 1. **`start-whatsapp-server.bat`** 🟢
**Fungsi:** Menjalankan WhatsApp Server (Node.js/Baileys)

**Lokasi Server:** `anywhatzap/anywhatzap/`

**Apa yang dilakukan:**
- Cek apakah Node.js terinstall
- Install dependencies (npm install) jika belum ada
- Menjalankan `node app.js`
- Menampilkan QR Code untuk connect WhatsApp

**Cara Pakai:**
1. Double-click file `start-whatsapp-server.bat`
2. Tunggu sampai QR Code muncul
3. Scan QR Code dengan WhatsApp di HP
4. Server siap menerima request

---

### 2. **`start-laravel-server.bat`** 🔵
**Fungsi:** Menjalankan Laravel Application Server

**Apa yang dilakukan:**
- Cek apakah PHP terinstall
- Install dependencies (composer install) jika belum ada
- Generate APP_KEY jika belum ada
- Clear semua cache Laravel
- Menjalankan `php artisan serve` di http://127.0.0.1:8000

**Cara Pakai:**
1. Double-click file `start-laravel-server.bat`
2. Tunggu sampai muncul "Server running on http://127.0.0.1:8000"
3. Buka browser ke http://127.0.0.1:8000

---

### 3. **`start-both-servers.bat`** 🟣 (RECOMMENDED!)
**Fungsi:** Menjalankan KEDUA server sekaligus

**Apa yang dilakukan:**
- Membuka 2 window terpisah
- Window 1: WhatsApp Server
- Window 2: Laravel Server
- Kedua server berjalan bersamaan

**Cara Pakai:**
1. Double-click file `start-both-servers.bat`
2. Akan muncul 2 window command prompt
3. Window pertama untuk WhatsApp Server (scan QR code)
4. Window kedua untuk Laravel Server
5. Aplikasi siap digunakan!

**⚠️ Catatan:** Kedua server HARUS berjalan agar aplikasi berfungsi dengan baik!

---

### 4. **`install-dependencies.bat`** 📦
**Fungsi:** Install semua dependencies untuk pertama kali

**Apa yang dilakukan:**
- Install dependencies Node.js (`npm install`)
- Install dependencies PHP (`composer install`)

**Kapan digunakan:**
- Pertama kali setup project
- Setelah pull dari Git
- Setelah menghapus folder `node_modules` atau `vendor`

**Cara Pakai:**
1. Double-click file `install-dependencies.bat`
2. Tunggu proses selesai (bisa 5-10 menit tergantung internet)
3. Setelah selesai, bisa langsung jalankan server

---

### 5. **`stop-all-servers.bat`** 🔴
**Fungsi:** Stop semua server yang berjalan

**Apa yang dilakukan:**
- Menghentikan semua proses PHP (php.exe)
- Menghentikan semua proses Node.js (node.exe)

**Kapan digunakan:**
- Setelah selesai development
- Ketika ingin restart server
- Ketika server hang/error

**Cara Pakai:**
1. Double-click file `stop-all-servers.bat`
2. Semua server akan dihentikan paksa

---

## 🚀 Quick Start Guide

### Untuk Pertama Kali:

```
1. Jalankan: install-dependencies.bat
   (Tunggu sampai selesai install semua dependencies)

2. Jalankan: start-both-servers.bat
   (Kedua server akan mulai berjalan)

3. Scan QR Code di window WhatsApp Server

4. Buka browser: http://127.0.0.1:8000

5. Login dan mulai gunakan aplikasi!
```

### Untuk Penggunaan Sehari-hari:

```
1. Jalankan: start-both-servers.bat

2. Tunggu kedua server siap

3. Gunakan aplikasi

4. Jika selesai: stop-all-servers.bat
```

---

## 🔧 Troubleshooting

### Error: "Node.js is not installed"
**Solusi:**
1. Download Node.js dari https://nodejs.org/
2. Install Node.js (pilih LTS version)
3. Restart command prompt
4. Coba lagi jalankan file .bat

### Error: "PHP is not installed"
**Solusi:**
1. PHP sudah terinstall di `D:\php\php.exe`
2. Pastikan PHP ada di PATH environment variable
3. Atau edit file .bat untuk gunakan path lengkap

### Error: Port 8000 already in use
**Solusi:**
1. Jalankan `stop-all-servers.bat`
2. Atau ubah port di `start-laravel-server.bat`:
   ```batch
   php artisan serve --port=8001
   ```

### WhatsApp QR Code tidak muncul
**Solusi:**
1. Pastikan folder `anywhatzap/anywhatzap/auth_info_baileys` ada
2. Hapus folder tersebut jika ada masalah
3. Restart WhatsApp Server
4. Scan QR Code baru

### Laravel menampilkan error 500
**Solusi:**
1. Pastikan file `.env` ada dan terisi dengan benar
2. Jalankan:
   ```bash
   php artisan key:generate
   php artisan config:clear
   php artisan cache:clear
   ```
3. Cek database connection di `.env`

---

## 📝 Struktur Project

```
wahblast-new/
├── anywhatzap/
│   └── anywhatzap/          ← WhatsApp Server (Node.js)
│       ├── app.js           ← Main file
│       ├── package.json
│       └── node_modules/
├── app/                     ← Laravel Application
├── public/                  ← Laravel Public folder
├── .env                     ← Laravel Config
├── composer.json           ← PHP Dependencies
├── package.json            ← (Laravel frontend)
│
├── start-whatsapp-server.bat    ← Run WhatsApp Server
├── start-laravel-server.bat     ← Run Laravel Server
├── start-both-servers.bat       ← Run BOTH (Recommended!)
├── install-dependencies.bat     ← Install all dependencies
└── stop-all-servers.bat         ← Stop all servers
```

---

## 🌐 Default Ports

| Service | Port | URL |
|---------|------|-----|
| Laravel Server | 8000 | http://127.0.0.1:8000 |
| WhatsApp Server | 3000 | http://127.0.0.1:3000 (atau cek di .env) |

---

## ✅ Checklist Sebelum Menjalankan

- [ ] Node.js terinstall (check: `node --version`)
- [ ] PHP terinstall (check: `php -v`)
- [ ] Composer terinstall (check: `composer --version`)
- [ ] File `.env` sudah ada dan terisi
- [ ] Database sudah dibuat (sesuai `.env`)
- [ ] Dependencies sudah terinstall

---

## 💡 Tips

1. **Selalu jalankan kedua server** - Laravel dan WhatsApp Server harus berjalan bersamaan
2. **Gunakan `start-both-servers.bat`** untuk kemudahan
3. **Jangan tutup window command prompt** selama aplikasi digunakan
4. **Scan QR Code sekali saja** - Session WhatsApp akan tersimpan
5. **Stop server dengan benar** - Gunakan `stop-all-servers.bat` atau Ctrl+C

---

## 🆘 Support

Jika ada masalah:
1. Cek error message di command prompt
2. Baca dokumentasi upgrade di `PHP_8.4_UPGRADE_GUIDE.md`
3. Cek log Laravel di `storage/logs/laravel.log`

---

**Happy Coding!** 🎉
