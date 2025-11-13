# ✅ Checklist Instalasi - Scholar System

Ikuti langkah-langkah ini secara berurutan:

---

## 📋 Persiapan

- [ ] PHP 8.2+ terinstall
- [ ] Composer terinstall
- [ ] Node.js 18+ terinstall
- [ ] MySQL/MariaDB terinstall (atau gunakan SQLite)

---

## 🚀 Instalasi Step-by-Step

### 1. Masuk ke Folder Proyek
```bash
cd scholar-system
```
- [ ] Sudah masuk ke folder `scholar-system`

---

### 2. Install PHP Dependencies
```bash
composer install
```
- [ ] Composer install berhasil
- [ ] Folder `vendor/` sudah ada

---

### 3. Install JavaScript Dependencies
```bash
npm install
```
- [ ] NPM install berhasil
- [ ] Folder `node_modules/` sudah ada

---

### 4. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```
- [ ] File `.env` sudah ada
- [ ] APP_KEY sudah terisi

---

### 5. Konfigurasi Database

**Pilihan A: SQLite (Mudah, sudah default)**
- [ ] Tidak perlu konfigurasi tambahan
- [ ] File `database/database.sqlite` akan auto-create

**Pilihan B: MySQL**
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scholar_system
DB_USERNAME=root
DB_PASSWORD=
```
- [ ] Database `scholar_system` sudah dibuat
- [ ] Kredensial database sudah benar

---

### 6. Migrasi Database
```bash
php artisan migrate --seed
```
- [ ] Migrasi berhasil
- [ ] Data seeder berhasil
- [ ] Tabel articles, references, comments, users sudah ada

---

### 7. Install Filament
```bash
composer require filament/filament:"^3.2"
php artisan filament:install --panels
```
- [ ] Filament terinstall
- [ ] Panel admin terkonfigurasi

---

### 8. Install Sanctum
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```
- [ ] Sanctum terinstall
- [ ] Config sanctum sudah publish

---

### 9. Install Inertia
```bash
composer require inertiajs/inertia-laravel
php artisan inertia:middleware
```
- [ ] Inertia terinstall
- [ ] Middleware terdaftar

---

### 10. Storage Link
```bash
php artisan storage:link
```
- [ ] Symlink storage berhasil
- [ ] Folder `public/storage` sudah ada

---

### 11. Build Assets (Opsional untuk Development)
```bash
npm run build
```
- [ ] Build berhasil
- [ ] Folder `public/build` sudah ada

---

### 12. Jalankan Aplikasi

**Terminal 1: Laravel Server**
```bash
php artisan serve
```
- [ ] Server berjalan di http://localhost:8000

**Terminal 2: Vite Dev Server**
```bash
npm run dev
```
- [ ] Vite berjalan
- [ ] Hot reload aktif

---

## 🧪 Testing

### 1. Akses Frontend
- [ ] Buka http://localhost:8000
- [ ] Halaman home muncul
- [ ] Navigasi berfungsi

### 2. Akses Admin Panel
- [ ] Buka http://localhost:8000/admin
- [ ] Halaman login muncul
- [ ] Login dengan: admin@scholar.com / password
- [ ] Dashboard admin muncul

### 3. Test CRUD Artikel
- [ ] Klik menu "Artikel"
- [ ] Klik "Create"
- [ ] Isi form artikel
- [ ] Save berhasil
- [ ] Artikel muncul di list

### 4. Test Referensi
- [ ] Edit artikel
- [ ] Klik tab "Daftar Referensi"
- [ ] Tambah referensi
- [ ] Save berhasil

### 5. Test Frontend Artikel
- [ ] Buka http://localhost:8000/artikel
- [ ] Artikel muncul
- [ ] Klik artikel
- [ ] Detail artikel muncul
- [ ] Referensi tampil di bawah

### 6. Test Komentar
- [ ] Login sebagai user
- [ ] Tulis komentar
- [ ] Submit berhasil
- [ ] Komentar menunggu approval

### 7. Test Moderasi Komentar
- [ ] Login admin
- [ ] Menu "Komentar"
- [ ] Approve komentar
- [ ] Komentar muncul di frontend

---

## 🔍 Verifikasi Metadata Scholar

### 1. View Page Source
- [ ] Buka artikel di frontend
- [ ] Klik kanan → View Page Source
- [ ] Cari `<meta name="citation_title"`
- [ ] Metadata citation_* ada
- [ ] JSON-LD ScholarlyArticle ada

### 2. Test Sitemap
- [ ] Buka http://localhost:8000/sitemap.xml
- [ ] XML sitemap muncul
- [ ] Artikel terdaftar di sitemap

### 3. Test Robots.txt
- [ ] Buka http://localhost:8000/robots.txt
- [ ] File robots.txt muncul
- [ ] Sitemap URL tercantum

---

## 🎨 Verifikasi Tampilan

- [ ] Navbar tampil dengan benar
- [ ] Footer tampil
- [ ] Warna biru (#3b82f6) konsisten
- [ ] Font Inter terload
- [ ] Responsive di mobile
- [ ] Card artikel rapi
- [ ] Button hover berfungsi

---

## 📊 Data Seeder

Setelah `php artisan migrate --seed`, Anda punya:

**Users:**
- [ ] Admin: admin@scholar.com / password
- [ ] Dosen: dosen@scholar.com / password

**Artikel:**
- [ ] 2 artikel contoh
- [ ] Dengan referensi
- [ ] Status published

---

## 🐛 Troubleshooting

### Error: Vite manifest not found
```bash
npm run build
```
- [ ] Sudah run build

### Error: Class 'Inertia' not found
```bash
composer require inertiajs/inertia-laravel
```
- [ ] Inertia sudah terinstall

### Error: Storage link
```bash
php artisan storage:link
```
- [ ] Symlink sudah dibuat

### Error: Permission denied
```bash
chmod -R 775 storage bootstrap/cache
```
- [ ] Permission sudah diubah

---

## ✅ Instalasi Selesai!

Jika semua checklist di atas sudah ✅, maka:

🎉 **SISTEM SIAP DIGUNAKAN!**

**Akses:**
- Frontend: http://localhost:8000
- Admin: http://localhost:8000/admin

**Login:**
- Admin: admin@scholar.com / password
- Dosen: dosen@scholar.com / password

---

## 📚 Dokumentasi Lanjutan

Baca file-file ini untuk detail lebih lanjut:
- `README.md` - Overview
- `QUICK_START.md` - Panduan cepat
- `DOKUMENTASI_LENGKAP.md` - Dokumentasi teknis
- `DEPLOYMENT.md` - Deploy ke production

---

**Selamat! Sistem Scholar Anda sudah berjalan! 🚀**
