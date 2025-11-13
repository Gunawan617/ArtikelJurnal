# 📚 Dokumentasi Lengkap - Scholar System

## 🎯 Ringkasan Proyek

Sistem web artikel ilmiah berbasis **Laravel 11 fullstack** dengan:
- **Backend**: Laravel 11 + Filament 3.x (Admin Panel)
- **Frontend**: React 18 + Inertia.js + Tailwind CSS
- **Database**: MySQL/SQLite
- **Auth**: Laravel Sanctum
- **Tujuan**: Artikel terindeks di Google Scholar

---

## 📁 Struktur File Penting

```
scholar-system/
├── app/
│   ├── Models/
│   │   ├── Article.php          # Model artikel
│   │   ├── Reference.php        # Model referensi
│   │   └── Comment.php          # Model komentar
│   ├── Filament/Resources/
│   │   ├── ArticleResource.php  # CRUD artikel di Filament
│   │   └── CommentResource.php  # Moderasi komentar
│   └── Http/Controllers/
│       ├── Api/
│       │   ├── ArticleController.php
│       │   └── CommentController.php
│       └── SitemapController.php
├── database/migrations/
│   ├── 2024_01_01_000001_create_articles_table.php
│   ├── 2024_01_01_000002_create_references_table.php
│   ├── 2024_01_01_000003_create_comments_table.php
│   └── 2024_01_01_000004_add_role_to_users_table.php
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   │   ├── Home.jsx
│   │   │   ├── Articles/Index.jsx
│   │   │   ├── Articles/Show.jsx  # ⭐ Metadata Scholar di sini
│   │   │   └── About.jsx
│   │   ├── Layouts/Layout.jsx
│   │   └── app.jsx
│   └── css/app.css
├── routes/
│   ├── web.php                  # Route frontend
│   └── api.php                  # API endpoints
└── public/
    └── robots.txt
```

---

## 🗄️ Database Schema

### Table: `articles`
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| title | string | Judul artikel |
| slug | string | URL-friendly |
| abstract | text | Abstrak |
| keywords | string | Kata kunci (comma-separated) |
| author | string | Nama penulis |
| pdf_path | string | Path file PDF |
| image_path | string | Path gambar artikel |
| published_at | timestamp | Tanggal publikasi |
| is_published | boolean | Status publikasi |
| user_id | bigint | Foreign key ke users |

### Table: `references`
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| article_id | bigint | Foreign key ke articles |
| author | string | Penulis referensi |
| title | string | Judul referensi |
| year | string | Tahun publikasi |
| journal | string | Nama jurnal |
| doi | string | DOI (Digital Object Identifier) |
| url | string | URL referensi |
| order | integer | Urutan tampil |

### Table: `comments`
| Field | Type | Keterangan |
|-------|------|------------|
| id | bigint | Primary key |
| article_id | bigint | Foreign key ke articles |
| user_id | bigint | Foreign key ke users |
| parent_id | bigint | Untuk nested reply |
| content | text | Isi komentar |
| approved | boolean | Status moderasi |

### Table: `users`
| Field | Type | Keterangan |
|-------|------|------------|
| role | enum | admin, dosen, pembaca |

---

## 🔍 Metadata Google Scholar

### Di `Articles/Show.jsx`:

```jsx
// Meta tags di <Head>
<meta name="citation_title" content="{title}" />
<meta name="citation_author" content="{author}" />
<meta name="citation_publication_date" content="{published_at}" />
<meta name="citation_pdf_url" content="{pdf_url}" />
<meta name="citation_abstract_html_url" content="{article_url}" />

// JSON-LD Schema
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ScholarlyArticle",
  "headline": "{title}",
  "author": { "name": "{author}" },
  "datePublished": "{published_at}",
  "abstract": "{abstract}",
  "keywords": "{keywords}",
  "citation": [...]
}
</script>
```

---

## 🚀 API Endpoints

### Public Endpoints
```
GET  /api/articles              # List semua artikel
GET  /api/articles/{slug}       # Detail artikel
GET  /api/articles/{slug}/comments  # Komentar artikel
```

### Protected Endpoints (Auth Required)
```
POST /api/articles/{slug}/comment   # Tambah komentar
POST /api/comments/{id}/reply       # Reply komentar
```

---

## 🎨 Komponen React

### 1. Home.jsx
- Hero section dengan CTA
- Fitur unggulan (3 kolom)
- Desain mirip Alodokter

### 2. Articles/Index.jsx
- Grid layout artikel (3 kolom)
- Card dengan gambar, judul, abstrak
- Fetch data dari API

### 3. Articles/Show.jsx ⭐
- **Header**: Judul, penulis, tanggal
- **Gambar**: Featured image
- **Abstrak**: Konten utama
- **Kata Kunci**: Badge biru
- **Download PDF**: Button
- **Referensi**: Ordered list dengan DOI link
- **Komentar**: Nested comments dengan form
- **Metadata**: Citation meta + JSON-LD

### 4. Layout.jsx
- Navbar: Home, Artikel, Tentang, Admin
- Footer: Copyright
- Warna: Biru (#3b82f6) + Putih

---

## 🛠️ Filament Resources

### ArticleResource.php
**Form Fields:**
- TextInput: title, slug, author, keywords
- Textarea: abstract
- FileUpload: pdf_path, image_path
- DateTimePicker: published_at
- Toggle: is_published

**Relation Manager:**
- ReferencesRelationManager (CRUD referensi)

**Table Columns:**
- title, author, is_published, published_at

### CommentResource.php
**Form Fields:**
- Select: article_id
- Textarea: content
- Toggle: approved

**Table:**
- user.name, article.title, content, approved, created_at

---

## 📝 Cara Pakai

### Untuk Dosen:
1. Login ke `/admin` (email: dosen@scholar.com, pass: password)
2. Menu "Artikel" → Create
3. Isi form artikel
4. Tab "Daftar Referensi" → Tambah referensi
5. Centang "Publikasikan" → Save
6. Artikel muncul di frontend

### Untuk Pembaca:
1. Buka `/artikel`
2. Klik artikel untuk baca detail
3. Login untuk komentar
4. Komentar menunggu approval admin

### Untuk Admin:
1. Login ke `/admin`
2. Menu "Komentar" → Approve/Delete
3. Menu "Artikel" → Edit/Delete

---

## 🔧 Konfigurasi Penting

### 1. Inertia Middleware
File: `app/Http/Middleware/HandleInertiaRequests.php`
- Share auth user ke semua page
- Flash messages

### 2. Bootstrap App
File: `bootstrap/app.php`
- Register Inertia middleware
- Sanctum API middleware

### 3. Vite Config
File: `vite.config.js`
- React plugin
- Alias `@` untuk `/resources/js`

### 4. Tailwind Config
File: `tailwind.config.js`
- Custom colors (primary blue)
- Typography plugin
- Forms plugin

---

## 🌐 SEO & Crawler

### Sitemap
- URL: `/sitemap.xml`
- Auto-generate dari artikel published
- Update otomatis saat artikel baru

### Robots.txt
```
User-agent: *
Allow: /
Disallow: /admin
Disallow: /api
Sitemap: http://localhost:8000/sitemap.xml
```

### Tips Agar Terindeks Scholar:
1. ✅ Halaman artikel harus publik (tanpa login)
2. ✅ Metadata citation_* lengkap
3. ✅ JSON-LD ScholarlyArticle
4. ✅ PDF dengan metadata internal
5. ✅ Referensi dalam format terstruktur (ol/li)
6. ✅ Sitemap.xml berisi semua artikel
7. ✅ Robots.txt allow crawler
8. ✅ Canonical URL di setiap artikel

---

## 🎨 Desain Mirip Alodokter

### Warna:
- Primary: Blue (#3b82f6)
- Background: Gray-50 (#f9fafb)
- Text: Gray-900 (#111827)
- Accent: Blue-100 (#dbeafe)

### Typography:
- Font: Inter (Google Fonts)
- Heading: Bold, 2xl-4xl
- Body: Regular, base-lg

### Layout:
- Max-width: 4xl-6xl
- Padding: 4-8
- Rounded: lg
- Shadow: sm-md

### Components:
- Card: bg-white, rounded-lg, shadow-sm
- Button: bg-blue-600, hover:bg-blue-700
- Badge: bg-blue-50, text-blue-700

---

## 🐛 Troubleshooting

### Error: Vite manifest not found
```bash
npm run build
```

### Error: Class 'Inertia' not found
```bash
composer require inertiajs/inertia-laravel
php artisan inertia:middleware
```

### Error: Storage link
```bash
php artisan storage:link
```

### Error: Filament not found
```bash
composer require filament/filament:"^3.2"
php artisan filament:install --panels
```

### Komentar tidak muncul
- Cek field `approved` di database (harus true)
- Approve via admin panel

---

## 📦 Dependencies

### Composer (PHP)
```json
{
  "filament/filament": "^3.2",
  "laravel/sanctum": "^4.0",
  "inertiajs/inertia-laravel": "^1.0"
}
```

### NPM (JavaScript)
```json
{
  "@inertiajs/react": "^1.0.0",
  "@vitejs/plugin-react": "^4.2.0",
  "react": "^18.2.0",
  "react-dom": "^18.2.0",
  "tailwindcss": "^3.2.1",
  "@tailwindcss/typography": "^0.5.9",
  "@tailwindcss/forms": "^0.5.3"
}
```

---

## ✅ Checklist Fitur

- [x] CRUD Artikel (Filament)
- [x] Upload PDF & Gambar
- [x] Daftar Referensi (Relasi)
- [x] Komentar Nested
- [x] Moderasi Komentar
- [x] Metadata Google Scholar
- [x] JSON-LD Schema
- [x] Sitemap.xml
- [x] Robots.txt
- [x] API Endpoints
- [x] Auth Sanctum
- [x] Tampilan Modern (Tailwind)
- [x] Responsive Design
- [x] SEO Optimized

---

## 🎓 Referensi

- Laravel Docs: https://laravel.com/docs
- Filament Docs: https://filamentphp.com/docs
- Inertia.js: https://inertiajs.com
- React: https://react.dev
- Tailwind CSS: https://tailwindcss.com
- Google Scholar Metadata: https://scholar.google.com/intl/en/scholar/inclusion.html

---

**Selamat menggunakan Scholar System! 🎉**
