# 📚 Scholar System - Platform Artikel Ilmiah

> Sistem web artikel ilmiah berbasis **Laravel 11 fullstack** dengan **React + Filament** yang **terindeks Google Scholar**. Tampilan modern mirip Alodokter.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel)
![React](https://img.shields.io/badge/React-18-61DAFB?logo=react)
![Filament](https://img.shields.io/badge/Filament-3.x-FDAE4B)
![Tailwind](https://img.shields.io/badge/Tailwind-3.x-38B2AC?logo=tailwind-css)

---

## ✨ Fitur Utama

- 🎓 **Panel Admin Filament** - Dosen kelola artikel dengan mudah
- 📄 **Upload PDF** - Artikel dengan metadata lengkap
- 📚 **Daftar Referensi** - Daftar pustaka terstruktur dengan DOI
- 💬 **Komentar Nested** - Diskusi interaktif dengan moderasi
- 🔍 **Google Scholar Ready** - Metadata citation_* + JSON-LD
- 🎨 **Desain Modern** - Tampilan bersih mirip Alodokter
- 🚀 **SEO Optimized** - Sitemap, robots.txt, canonical URL

---

## 🚀 Quick Start (5 Menit)

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Migrasi database (SQLite default)
php artisan migrate --seed

# 4. Storage link
php artisan storage:link

# 5. Jalankan!
php artisan serve    # Terminal 1
npm run dev          # Terminal 2
```

**Akses:**
- 🌐 Frontend: http://localhost:8000
- 🔐 Admin: http://localhost:8000/admin

**Login Default:**
- Admin: `admin@scholar.com` / `password`
- Dosen: `dosen@scholar.com` / `password`

> 📖 **Panduan lengkap:** Lihat [QUICK_START.md](QUICK_START.md) atau [CHECKLIST_INSTALASI.md](CHECKLIST_INSTALASI.md)

---

## 📁 Struktur Proyek

```
scholar-system/
├── app/
│   ├── Models/              # Article, Reference, Comment
│   ├── Filament/Resources/  # Admin CRUD
│   └── Http/Controllers/    # API & Sitemap
├── database/migrations/     # Schema database
├── resources/
│   ├── js/Pages/           # React components
│   └── css/                # Tailwind styles
├── routes/
│   ├── web.php             # Frontend routes
│   └── api.php             # API endpoints
└── public/                 # Assets & storage
```

---

## 🗄️ Database Schema

| Table | Kolom Utama |
|-------|-------------|
| **articles** | title, slug, abstract, keywords, author, pdf_path, published_at |
| **references** | article_id, author, title, year, journal, doi, url |
| **comments** | article_id, user_id, parent_id, content, approved |
| **users** | name, email, role (admin/dosen/pembaca) |

---

## 🎯 Cara Pakai

### 👨‍🏫 Untuk Dosen:

1. Login ke `/admin`
2. Menu **Artikel** → **Create**
3. Isi form: judul, abstrak, kata kunci, upload PDF
4. Tab **Daftar Referensi** → Tambah referensi
5. Centang **Publikasikan** → **Save**
6. Artikel muncul di frontend ✅

### 👥 Untuk Pembaca:

1. Buka `/artikel` untuk lihat semua artikel
2. Klik artikel untuk baca detail
3. Login untuk berkomentar
4. Komentar menunggu approval admin

---

## 🔍 Google Scholar Integration

Setiap artikel otomatis punya metadata lengkap:

```html
<!-- Citation Meta Tags -->
<meta name="citation_title" content="Judul Artikel" />
<meta name="citation_author" content="Nama Penulis" />
<meta name="citation_publication_date" content="2024-01-01" />
<meta name="citation_pdf_url" content="https://..." />

<!-- JSON-LD Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ScholarlyArticle",
  "headline": "...",
  "author": { "name": "..." },
  "citation": [...]
}
</script>
```

**SEO Features:**
- ✅ Sitemap.xml auto-generate
- ✅ Robots.txt configured
- ✅ Canonical URLs
- ✅ Structured references (ol/li)

---

## 📝 API Endpoints

```http
GET  /api/articles                    # List artikel
GET  /api/articles/{slug}             # Detail artikel
GET  /api/articles/{slug}/comments    # Komentar artikel

POST /api/articles/{slug}/comment     # Tambah komentar (auth)
POST /api/comments/{id}/reply         # Reply komentar (auth)
```

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend | Laravel 11 |
| Admin Panel | Filament 3.x |
| Frontend | React 18 + Inertia.js |
| Styling | Tailwind CSS |
| Database | MySQL / SQLite |
| Auth | Laravel Sanctum |
| Build | Vite |

---

## 📚 Dokumentasi

| File | Deskripsi |
|------|-----------|
| [QUICK_START.md](QUICK_START.md) | Panduan instalasi 5 menit |
| [CHECKLIST_INSTALASI.md](CHECKLIST_INSTALASI.md) | Checklist step-by-step |
| [DOKUMENTASI_LENGKAP.md](DOKUMENTASI_LENGKAP.md) | Dokumentasi teknis lengkap |
| [DEPLOYMENT.md](DEPLOYMENT.md) | Panduan deploy production |
| [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md) | Ringkasan proyek |

---

## 🎨 Screenshots

### Frontend (Mirip Alodokter)
- Halaman Home: Hero section + fitur unggulan
- Daftar Artikel: Grid layout 3 kolom
- Detail Artikel: Judul, abstrak, referensi, komentar

### Admin Panel (Filament)
- CRUD Artikel: Form lengkap dengan upload
- Daftar Referensi: Relation manager
- Moderasi Komentar: Approve/reject

---

## 🐛 Troubleshooting

**Error: Vite manifest not found**
```bash
npm run build
```

**Error: Class 'Inertia' not found**
```bash
composer require inertiajs/inertia-laravel
```

**Error: Storage link**
```bash
php artisan storage:link
```

> Lihat troubleshooting lengkap di [DOKUMENTASI_LENGKAP.md](DOKUMENTASI_LENGKAP.md)

---

## 🚀 Deployment

Untuk deploy ke production, ikuti panduan di [DEPLOYMENT.md](DEPLOYMENT.md):
- Setup server (Nginx/Apache)
- SSL certificate
- Queue worker
- Cron jobs
- Optimization

---

## 📄 License

MIT License - Bebas digunakan untuk proyek apapun.

---

## 🙏 Credits

Dibuat dengan ❤️ untuk kemudahan publikasi artikel ilmiah yang terindeks Google Scholar.

**Happy Coding! 🎉**
# ArtikelJurnal
