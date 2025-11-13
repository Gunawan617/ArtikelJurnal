# 🚀 Quick Start Guide

## Instalasi Super Cepat (5 Menit)

### 1. Install Dependencies
```bash
cd scholar-system
composer install
npm install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database (SQLite - Sudah Auto)
```bash
php artisan migrate --seed
```

### 4. Install Filament
```bash
composer require filament/filament:"^3.2"
php artisan filament:install --panels
```

### 5. Install Sanctum & Inertia
```bash
composer require laravel/sanctum inertiajs/inertia-laravel
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan inertia:middleware
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Jalankan!
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

## 🎉 Akses Aplikasi

- **Frontend**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin

### Login Admin:
- Email: `admin@scholar.com`
- Password: `password`

### Login Dosen:
- Email: `dosen@scholar.com`
- Password: `password`

## 📝 Cara Pakai

1. Login ke `/admin` dengan akun dosen
2. Klik menu "Artikel" → "Create"
3. Isi form artikel (judul, abstrak, kata kunci, dll)
4. Upload PDF (opsional)
5. Klik tab "Daftar Referensi" → Tambah referensi
6. Centang "Publikasikan" → Save
7. Buka frontend untuk lihat artikel

## 🔧 Troubleshooting

### Error: Class 'Inertia' not found
```bash
composer require inertiajs/inertia-laravel
php artisan inertia:middleware
```

### Error: Vite manifest not found
```bash
npm run build
```

### Error: Storage link
```bash
php artisan storage:link
```

## ✅ Checklist Fitur

- [x] CRUD Artikel via Filament
- [x] Upload PDF & Gambar
- [x] Daftar Referensi (Relasi)
- [x] Komentar Nested
- [x] Metadata Google Scholar
- [x] JSON-LD Schema
- [x] Tampilan Modern (Tailwind)
- [x] API Endpoints
- [x] Auth Sanctum

Selamat mencoba! 🎊
