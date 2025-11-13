# Dokumentasi Sistem Artikel

## 📋 Daftar Isi
1. [Homepage (/)](#homepage-)
2. [Halaman Artikel (/artikel)](#halaman-artikel-artikel)
3. [Algoritma Ranking](#algoritma-ranking)
4. [Struktur Database](#struktur-database)

---

## 🏠 Homepage (/)

### Layout Structure
Homepage menampilkan **5 artikel** dengan layout:
- **1 Artikel Featured** (Besar, 50% lebar)
- **4 Artikel Grid** (Kecil, 2x2 grid, 50% lebar)

### Algoritma Pemilihan Artikel

#### 1. Artikel Featured (Besar)
**Prioritas 1: Manual Featured**
```php
Article::where('is_published', true)
    ->where('is_featured', true)
    ->latest('published_at')
    ->first();
```
- Admin dapat menandai artikel sebagai featured di Filament Admin
- Artikel dengan flag `is_featured = true` akan diprioritaskan

**Prioritas 2: Smart Algorithm (Jika tidak ada featured manual)**
```php
Article::where('is_published', true)
    ->withCount('comments')
    ->orderByRaw('(comments_count * 2) + (DATEDIFF(NOW(), published_at) * -0.1) DESC')
    ->first();
```
- Artikel dengan **komentar terbanyak** mendapat prioritas
- Artikel baru mendapat sedikit boost
- Formula: `(jumlah_komentar × 2) - (umur_artikel × 0.1)`

#### 2. Artikel Grid (4 Artikel Kecil)
```php
Article::where('is_published', true)
    ->where('id', '!=', $featuredArticle?->id)
    ->withCount('comments')
    ->selectRaw('(
        (SELECT COUNT(*) FROM comments WHERE article_id = articles.id) * 2 +
        (CASE 
            WHEN DATEDIFF(NOW(), updated_at) < 7 THEN 10
            WHEN DATEDIFF(NOW(), updated_at) < 30 THEN 5
            ELSE 0
        END)
    ) as popularity_score')
    ->orderBy('popularity_score', 'desc')
    ->orderBy('published_at', 'desc')
    ->take(4)
    ->get();
```

**Popularity Score Formula:**
- Jumlah komentar × 2
- Artikel < 7 hari: +10 poin
- Artikel < 30 hari: +5 poin
- Artikel > 30 hari: +0 poin

**Contoh Perhitungan:**
```
Artikel A: 5 komentar, 3 hari yang lalu
Score = (5 × 2) + 10 = 20 poin

Artikel B: 10 komentar, 45 hari yang lalu
Score = (10 × 2) + 0 = 20 poin

Artikel C: 3 komentar, 2 hari yang lalu
Score = (3 × 2) + 10 = 16 poin
```

### Kapan Artikel Berubah?
Artikel di homepage akan **otomatis update** ketika:
- ✅ Ada artikel baru dipublish
- ✅ Ada artikel yang mendapat komentar baru
- ✅ Admin menandai artikel lain sebagai featured
- ✅ User refresh halaman (query dijalankan ulang)

---

## 📚 Halaman Artikel (/artikel)

### Layout Structure
Halaman artikel menampilkan artikel dengan layout:
- **1 Artikel Trending** (Besar, 50% lebar) - Kiri
- **3 Artikel Terbaru** (List, 50% lebar) - Kanan
- **9 Artikel Grid** (3x3 grid) - Bawah
- **Pagination** (9 artikel per halaman)

### Algoritma Pemilihan Artikel

#### 1. Artikel Trending (Kiri Besar) 🔥
```php
Article::where('is_published', true)
    ->where('updated_at', '>=', now()->subDays(30))
    ->withCount('comments')
    ->selectRaw('articles.*, (
        (SELECT COUNT(*) FROM comments WHERE article_id = articles.id) * 3 +
        (CASE 
            WHEN DATEDIFF(NOW(), updated_at) < 7 THEN 15
            WHEN DATEDIFF(NOW(), updated_at) < 14 THEN 10
            WHEN DATEDIFF(NOW(), updated_at) < 30 THEN 5
            ELSE 0
        END)
    ) as engagement_score')
    ->orderBy('engagement_score', 'desc')
    ->first();
```

**Engagement Score Formula:**
- Jumlah komentar × 3
- Artikel < 7 hari: +15 poin
- Artikel < 14 hari: +10 poin
- Artikel < 30 hari: +5 poin
- **Hanya artikel dalam 30 hari terakhir** yang dipertimbangkan

**Contoh Perhitungan:**
```
Artikel A: 8 komentar, 5 hari yang lalu
Score = (8 × 3) + 15 = 39 poin ⭐ TRENDING

Artikel B: 15 komentar, 60 hari yang lalu
Score = Tidak masuk (> 30 hari)

Artikel C: 4 komentar, 20 hari yang lalu
Score = (4 × 3) + 5 = 17 poin
```

#### 2. Artikel Terbaru (Kanan List) 📰
```php
Article::where('is_published', true)
    ->where('id', '!=', $topArticle->id)
    ->latest('published_at')
    ->take(3)
    ->get();
```
- 3 artikel dengan tanggal publish terbaru
- Exclude artikel trending
- Memastikan konten baru selalu terlihat

#### 3. Artikel Grid (Bawah)
```php
Article::where('is_published', true)
    ->whereNotIn('id', [$topArticle->id, ...$recentArticles->pluck('id')])
    ->latest('published_at')
    ->paginate(9);
```
- Artikel sisanya diurutkan berdasarkan tanggal publish
- Exclude artikel trending dan artikel terbaru
- 9 artikel per halaman (grid 3x3)

### Filter Kategori
```php
if ($request->has('category') && $request->category) {
    $query->where('category', $request->category);
}
```
- User dapat filter artikel berdasarkan kategori
- Semua algoritma (trending, terbaru, grid) akan mengikuti filter kategori
- URL: `/artikel?category=Teknologi`

---

## 🧮 Algoritma Ranking

### Perbedaan Homepage vs Halaman Artikel

| Aspek | Homepage | Halaman Artikel |
|-------|----------|-----------------|
| **Fokus** | Artikel populer & featured | Artikel trending & terbaru |
| **Timeframe** | Semua waktu | 30 hari terakhir |
| **Bobot Komentar** | × 2 | × 3 |
| **Bobot Freshness** | Rendah | Tinggi |
| **Jumlah Artikel** | 5 artikel | 13 artikel (1+3+9) |
| **Update** | Setiap refresh | Setiap refresh |

### Mengapa Berbeda?

**Homepage:**
- Menampilkan artikel terbaik sepanjang masa
- Artikel lama yang bagus tetap bisa muncul
- Fokus pada kualitas konten

**Halaman Artikel:**
- Menampilkan artikel yang sedang "hot" atau trending
- Artikel baru mendapat prioritas lebih tinggi
- Fokus pada engagement dan kesegaran konten

---

## 🗄️ Struktur Database

### Tabel: articles

| Field | Type | Deskripsi |
|-------|------|-----------|
| `id` | bigint | Primary key |
| `title` | string | Judul artikel |
| `slug` | string | URL-friendly identifier |
| `content` | text | Konten artikel (HTML) |
| `abstract` | text | Ringkasan artikel |
| `author` | string | Nama penulis |
| `author_title` | string | Gelar penulis (Dr., M.Sc., dll) |
| `author_institution` | string | Institusi penulis |
| `category` | string | Kategori artikel |
| `category_color` | string | Warna badge kategori |
| `keywords` | string | Kata kunci (comma-separated) |
| `image_path` | string | Path gambar artikel |
| `pdf_path` | string | Path file PDF |
| `is_published` | boolean | Status publikasi |
| `is_featured` | boolean | Flag artikel featured |
| `published_at` | timestamp | Tanggal publikasi |
| `created_at` | timestamp | Tanggal dibuat |
| `updated_at` | timestamp | Tanggal update terakhir |

### Tabel: comments

| Field | Type | Deskripsi |
|-------|------|-----------|
| `id` | bigint | Primary key |
| `article_id` | bigint | Foreign key ke articles |
| `user_id` | bigint | Foreign key ke users |
| `content` | text | Isi komentar |
| `created_at` | timestamp | Tanggal dibuat |
| `updated_at` | timestamp | Tanggal update |

### Relasi
```php
// Article Model
public function comments()
{
    return $this->hasMany(Comment::class);
}

// Comment Model
public function article()
{
    return $this->belongsTo(Article::class);
}
```

---

## 🎯 Tips Optimasi

### 1. Meningkatkan Ranking Artikel
Untuk membuat artikel muncul di homepage atau trending:
- ✅ Publikasikan artikel baru (dapat boost freshness)
- ✅ Update artikel lama (refresh `updated_at`)
- ✅ Dorong user untuk berkomentar
- ✅ Tandai sebagai featured (untuk homepage)

### 2. Cache (Opsional)
Untuk website dengan traffic tinggi, pertimbangkan caching:
```php
// Cache homepage articles selama 5 menit
$featuredArticle = Cache::remember('homepage.featured', 300, function() {
    return Article::where('is_published', true)
        ->where('is_featured', true)
        ->latest('published_at')
        ->first();
});
```

### 3. Index Database
Pastikan index database untuk performa optimal:
```sql
CREATE INDEX idx_articles_published ON articles(is_published, published_at);
CREATE INDEX idx_articles_featured ON articles(is_featured, published_at);
CREATE INDEX idx_articles_updated ON articles(updated_at);
CREATE INDEX idx_comments_article ON comments(article_id);
```

---

## 📝 Changelog

### Version 1.0 (13 November 2025)
- ✅ Implementasi smart algorithm untuk homepage
- ✅ Implementasi hybrid system untuk halaman artikel
- ✅ Sistem trending berdasarkan engagement 30 hari terakhir
- ✅ Filter kategori untuk halaman artikel
- ✅ Pagination 9 artikel per halaman

---

## 🤝 Kontributor
- **Developer:** Kiro AI Assistant
- **Tanggal:** 13 November 2025
