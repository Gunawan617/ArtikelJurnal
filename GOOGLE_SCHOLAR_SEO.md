# 🎓 Google Scholar Indexing Guide

## ✅ Yang Sudah Ada (Ready for Google Scholar)

### 1. **Meta Tags Lengkap** ✅
Setiap artikel sudah dilengkapi dengan:

#### Google Scholar Meta Tags:
```html
<meta name="citation_title" content="...">
<meta name="citation_author" content="...">
<meta name="citation_publication_date" content="...">
<meta name="citation_journal_title" content="...">
<meta name="citation_author_institution" content="...">
<meta name="citation_abstract" content="...">
<meta name="citation_keywords" content="...">
<meta name="citation_pdf_url" content="...">
<meta name="citation_fulltext_html_url" content="...">
```

#### Dublin Core Meta Tags:
```html
<meta name="DC.title" content="...">
<meta name="DC.creator" content="...">
<meta name="DC.date" content="...">
<meta name="DC.identifier" content="...">
```

#### Schema.org JSON-LD:
```json
{
  "@type": "ScholarlyArticle",
  "headline": "...",
  "author": {...},
  "datePublished": "...",
  "abstract": "..."
}
```

### 2. **Data Artikel Lengkap** ✅
- ✅ Judul (Title)
- ✅ Penulis (Author)
- ✅ Institusi (Institution)
- ✅ Tanggal Publikasi (Publication Date)
- ✅ Abstrak (Abstract)
- ✅ Kata Kunci (Keywords)
- ✅ PDF File (Optional)
- ✅ Referensi (References)
- ✅ Full Text HTML

### 3. **URL Structure** ✅
- Clean URLs: `/artikel/judul-artikel`
- Permanent links (slug-based)
- SEO-friendly

### 4. **Sitemap** ✅
- XML Sitemap: `/sitemap.xml`
- Auto-generated untuk semua artikel

### 5. **Robots.txt** ✅
- Mengizinkan Google Scholar crawler
- Path: `/robots.txt`

---

## 📋 Checklist Google Scholar Requirements

| Requirement | Status | Notes |
|------------|--------|-------|
| **Meta Tags** | ✅ | Citation meta tags lengkap |
| **Author Info** | ✅ | Nama, institusi, bio |
| **Publication Date** | ✅ | ISO 8601 format |
| **Abstract** | ✅ | Plain text, no HTML |
| **Keywords** | ✅ | Comma-separated |
| **PDF File** | ✅ | Optional, tapi recommended |
| **Full Text HTML** | ✅ | Accessible URL |
| **References** | ✅ | Structured data |
| **Unique URLs** | ✅ | Slug-based permalinks |
| **Sitemap** | ✅ | XML sitemap |
| **Robots.txt** | ✅ | Allow Googlebot |
| **HTTPS** | ⚠️ | Required for production |
| **Domain Authority** | ⏳ | Butuh waktu |

---

## 🚀 Langkah Agar Terindeks Google Scholar

### 1. **Deploy ke Production**
```bash
# Pastikan menggunakan HTTPS
# Domain: https://yourdomain.com
```

### 2. **Submit ke Google Scholar**
- **Tidak ada form submit langsung**
- Google Scholar akan **otomatis crawl** website Anda
- Pastikan website sudah **public** dan **accessible**

### 3. **Verifikasi Meta Tags**
Cek apakah meta tags sudah benar:
```bash
curl -s https://yourdomain.com/artikel/judul-artikel | grep "citation_"
```

### 4. **Submit Sitemap ke Google Search Console**
```
1. Daftar di Google Search Console
2. Verify domain Anda
3. Submit sitemap: https://yourdomain.com/sitemap.xml
```

### 5. **Tunggu Indexing (1-4 Minggu)**
- Google Scholar crawl tidak sesering Google Search
- Biasanya butuh **2-4 minggu** untuk artikel baru
- Artikel dengan PDF lebih cepat terindeks

---

## 💡 Tips Agar Cepat Terindeks

### 1. **Upload PDF** ⭐⭐⭐
- Artikel dengan PDF **lebih prioritas** di Google Scholar
- Format: PDF/A (archival format)
- Ukuran: < 10MB

### 2. **Referensi Lengkap** ⭐⭐⭐
- Minimal 5-10 referensi
- Format standar (APA, IEEE, dll)
- Link ke artikel lain yang sudah terindeks

### 3. **Institusi Terpercaya** ⭐⭐
- Gunakan email institusi (.ac.id, .edu)
- Cantumkan nama universitas/lembaga

### 4. **Konten Berkualitas** ⭐⭐⭐
- Minimal 2000 kata
- Struktur akademik (Abstrak, Pendahuluan, Metode, Hasil, Kesimpulan)
- Bahasa formal

### 5. **Backlinks** ⭐⭐
- Share artikel di platform akademik (ResearchGate, Academia.edu)
- Link dari website universitas
- Sitasi dari artikel lain

### 6. **Update Berkala** ⭐
- Publish artikel baru secara konsisten
- Minimal 1-2 artikel per bulan

---

## 🔍 Cara Cek Apakah Sudah Terindeks

### 1. **Google Scholar Search**
```
site:yourdomain.com "judul artikel"
```

### 2. **Google Scholar Profile**
- Buat profile Google Scholar
- Claim artikel Anda
- Verifikasi authorship

### 3. **Google Search Console**
- Cek coverage report
- Lihat indexed pages
- Monitor crawl errors

---

## ⚠️ Yang Masih Perlu Dilakukan

### 1. **HTTPS (WAJIB untuk Production)** 🔴
```bash
# Install SSL Certificate
# Gunakan Let's Encrypt (gratis)
sudo certbot --nginx -d yourdomain.com
```

### 2. **Custom Domain** 🔴
- Beli domain (.com, .id, .ac.id)
- Jangan gunakan localhost atau IP

### 3. **Hosting Production** 🔴
- VPS atau Cloud Hosting
- Minimal 2GB RAM
- PHP 8.2, MySQL 8.0

### 4. **Google Scholar Profile** 🟡
- Buat profile untuk setiap author
- Verify email institusi
- Claim articles

### 5. **DOI (Optional)** 🟢
- Digital Object Identifier
- Butuh registrasi ke Crossref/DataCite
- Biaya: ~$1-2 per artikel

---

## 📊 Monitoring & Analytics

### 1. **Google Search Console**
- Track impressions & clicks
- Monitor indexing status
- Fix crawl errors

### 2. **Google Analytics**
- Track visitor behavior
- Monitor article views
- Analyze traffic sources

### 3. **Google Scholar Metrics**
- H-index
- Citation count
- i10-index

---

## 🎯 Expected Timeline

| Milestone | Timeline |
|-----------|----------|
| Website live | Day 1 |
| Google crawl | 1-7 days |
| Google Search index | 1-2 weeks |
| Google Scholar crawl | 2-4 weeks |
| First citation | 1-6 months |
| Established presence | 6-12 months |

---

## 📚 Resources

- [Google Scholar Inclusion Guidelines](https://scholar.google.com/intl/en/scholar/inclusion.html)
- [Highwire Press Meta Tags](https://scholar.google.com/intl/en/scholar/inclusion.html#indexing)
- [Dublin Core Metadata](https://www.dublincore.org/specifications/dublin-core/)
- [Schema.org ScholarlyArticle](https://schema.org/ScholarlyArticle)

---

## ✅ Kesimpulan

**Sistem Anda SUDAH SIAP untuk Google Scholar!** 🎉

Yang perlu dilakukan:
1. ✅ Meta tags lengkap
2. ✅ Data artikel terstruktur
3. ✅ Sitemap & robots.txt
4. ⏳ Deploy ke production dengan HTTPS
5. ⏳ Tunggu Google Scholar crawl (2-4 minggu)

**Rekomendasi:**
- Upload PDF untuk setiap artikel (prioritas tinggi)
- Publish minimal 10-20 artikel berkualitas
- Gunakan email institusi untuk author
- Share artikel di platform akademik

---

**Last Updated**: November 12, 2025
