# 🐛 Troubleshooting Guide

## Error: Vite manifest not found

**Pesan Error:**
```
Vite manifest not found at: public/build/manifest.json
```

**Solusi:**
```bash
npm run build
```

Atau untuk development:
```bash
npm run dev
```

---

## Error: Class 'Inertia' not found

**Solusi:**
```bash
composer require inertiajs/inertia-laravel
php artisan inertia:middleware
```

---

## Error: Storage link

**Solusi:**
```bash
php artisan storage:link
```

---

## Error: Permission denied (storage/logs)

**Solusi:**
```bash
chmod -R 775 storage bootstrap/cache
```

---

## Panel Admin: /admin vs /eko

Jika ada 2 panel Filament, akses:
- `/admin` - Panel utama
- `/eko` - Panel alternatif (bisa dihapus)

Untuk menghapus panel "eko":
```bash
rm app/Providers/Filament/EkoPanelProvider.php
```

Lalu edit `config/app.php`, hapus EkoPanelProvider dari providers.

---

## Clear Cache

Jika ada masalah routing/config:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

---

## Database Error

Reset database:
```bash
php artisan migrate:fresh --seed
```

---

## NPM Error

Hapus dan install ulang:
```bash
rm -rf node_modules package-lock.json
npm install
```
