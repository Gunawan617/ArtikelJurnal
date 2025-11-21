# 🎯 Homepage Algorithm - Smart Article Ranking

## Overview

Sistem menggunakan **hybrid algorithm** yang menggabungkan:
1. Manual curation (featured flag)
2. Popularity metrics (views)
3. Freshness (artikel baru/update)
4. Engagement (diskusi, sitasi)

---

## 📊 Scoring System

### **Featured Article (Besar di Kiri)**

#### Priority 1: Manual Featured
```sql
WHERE is_featured = true
ORDER BY published_at DESC
LIMIT 1
```
- Admin bisa set artikel sebagai featured
- Prioritas tertinggi

#### Priority 2: Auto Featured (jika tidak ada manual)
```sql
Score = (views_count * 0.1) + (freshness_bonus) - (age_penalty)
```

**Formula:**
- **Views**: +0.1 points per view
- **Freshness**: 
  - < 7 hari: +10 points
  - < 30 hari: +5 points
  - > 30 hari: 0 points
- **Age Penalty**: -0.1 per hari

---

### **4 Artikel Kecil (Kanan)**

```sql
SELECT *, 
  (views_count * 0.1 + freshness_bonus) as popularity_score
FROM articles
WHERE is_published = true
  AND id != featured_article_id
ORDER BY popularity_score DESC, published_at DESC
LIMIT 4
```

**Ranking Factors:**
1. **Views** (40%): Total pembaca artikel
2. **Freshness** (30%): Update terbaru
3. **Recency** (30%): Tanggal publikasi

---

## 🔄 Cara Kerja

### Scenario 1: User Pertama Kali (No History)
```
Homepage menampilkan:
- Featured: Artikel dengan score tertinggi
- Lainnya: 4 artikel paling populer + fresh
```

### Scenario 2: User Sering Baca Kategori "Teknologi"
```
(Future Enhancement - Personalization)
Homepage menampilkan:
- Featured: Artikel Teknologi dengan score tertinggi
- Lainnya: Mix Teknologi (60%) + Kategori lain (40%)
```

### Scenario 3: Artikel Baru Dipublish
```
Artikel baru otomatis dapat +10 freshness bonus
Kemungkinan besar muncul di homepage (jika berkualitas)
```

### Scenario 4: Artikel Viral (Banyak Views)
```
Artikel dengan 100+ views:
Score = 100 * 0.1 = 10 points
Otomatis naik ke top 5
```

---

## 📈 Contoh Perhitungan Score

### Artikel A (Baru, Sedikit Views)
```
Published: 2 hari lalu
Views: 10
Updated: 2 hari lalu

Score = (10 * 0.1) + 10 + (2 * -0.1)
      = 1 + 10 - 0.2
      = 10.8 points
```

### Artikel B (Lama, Banyak Views)
```
Published: 60 hari lalu
Views: 150
Updated: 60 hari lalu

Score = (150 * 0.1) + 0 + (60 * -0.1)
      = 15 + 0 - 6
      = 9 points
```

**Winner: Artikel A** (Freshness + Views balance)

### Artikel C (Baru Diupdate, Medium Views)
```
Published: 90 hari lalu
Views: 50
Updated: 3 hari lalu (FRESH!)

Score = (50 * 0.1) + 10 + (3 * -0.1)
      = 5 + 10 - 0.3
      = 14.7 points
```

---

## 🎛️ Tuning Parameters

### Current Settings:
```php
VIEW_WEIGHT = 0.1         // Setiap view = 0.1 points
FRESH_BONUS_7D = 10       // Update < 7 hari = +10
FRESH_BONUS_30D = 5       // Update < 30 hari = +5
AGE_PENALTY = -0.1        // Per hari = -0.1
```

### Recommended Adjustments:

**Untuk Platform Baru (Butuh Konten Fresh):**
```php
VIEW_WEIGHT = 0.05
FRESH_BONUS_7D = 20  // Prioritas freshness
FRESH_BONUS_30D = 10
AGE_PENALTY = -0.2
```

**Untuk Platform Mature (Prioritas Quality):**
```php
VIEW_WEIGHT = 0.2   // Prioritas views
FRESH_BONUS_7D = 5
FRESH_BONUS_30D = 2
AGE_PENALTY = -0.05
```

---

## 🚀 Future Enhancements

### 1. **Personalization** (Phase 2)
```php
// Track user reading history
if (auth()->check()) {
    $userCategories = getUserFavoriteCategories(auth()->id());
    $articles = Article::whereIn('category', $userCategories)
        ->orderBy('popularity_score', 'desc')
        ->get();
}
```

### 2. **A/B Testing** (Phase 3)
```php
// Test different algorithms
$variant = session('homepage_variant', 'A');
if ($variant == 'A') {
    // Algorithm A: Freshness priority
} else {
    // Algorithm B: Engagement priority
}
```

### 3. **Machine Learning** (Phase 4)
```python
# Predict article popularity
features = [
    'author_reputation',
    'category_popularity',
    'title_length',
    'has_pdf',
    'reference_count'
]
model.predict(features)
```

### 4. **Real-time Trending** (Phase 5)
```php
// Track views in last 24 hours
$trending = Article::where('created_at', '>', now()->subDay())
    ->orderBy('views_24h', 'desc')
    ->get();
```

---

## 📊 Metrics to Track

### Homepage Performance:
- **CTR (Click-Through Rate)**: % user yang klik artikel
- **Bounce Rate**: % user yang langsung keluar
- **Time on Page**: Durasi baca artikel
- **Scroll Depth**: Seberapa jauh user scroll

### Article Performance:
- **Views**: Total pembaca (tracked automatically)
- **Comments**: Total komentar
- **Shares**: Total share (future)
- **Citations**: Total sitasi (Google Scholar)

### View Tracking:
- **Method**: IP-based throttling
- **Throttle**: 1 view per IP per artikel per 24 jam
- **Visibility**: Admin only (tidak ditampilkan di frontend)
- **Purpose**: Fair ranking tanpa bias engagement aktif

---

## 🔧 How to Adjust

### 1. **Set Featured Manual**
```
Admin Panel → Artikel → Edit → Toggle "Featured"
```

### 2. **Boost Artikel Tertentu**
```php
// Tambah komentar dummy (tidak recommended)
// Atau update artikel (recommended)
$article->touch(); // Update timestamp
```

### 3. **Change Algorithm**
Edit `routes/web.php`:
```php
Route::get('/', function () {
    // Modify scoring formula here
});
```

---

## ✅ Best Practices

1. **Publish Konsisten**: 1-2 artikel/minggu
2. **Update Artikel Lama**: Refresh konten berkala
3. **Encourage Comments**: Ajak diskusi di akhir artikel
4. **Quality > Quantity**: Artikel berkualitas = engagement tinggi
5. **Monitor Metrics**: Track CTR dan bounce rate

---

## 🎯 Goal

**Homepage yang:**
- ✅ Menampilkan konten terbaik
- ✅ Selalu fresh dan relevan
- ✅ Meningkatkan engagement
- ✅ Personalized (future)

---

**Last Updated**: November 12, 2025
