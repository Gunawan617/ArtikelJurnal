# 🔍 Cara Cek Meta Data Google Scholar

Panduan lengkap untuk memverifikasi bahwa website Anda sudah memiliki meta data yang benar untuk Google Scholar indexing.

---

## 📋 Table of Contents

1. [Cek Manual di Browser](#1-cek-manual-di-browser)
2. [Cek dengan Command Line](#2-cek-dengan-command-line)
3. [Cek dengan Online Tools](#3-cek-dengan-online-tools)
4. [Cek dengan Browser Extensions](#4-cek-dengan-browser-extensions)
5. [Validasi Meta Tags](#5-validasi-meta-tags)
6. [Troubleshooting](#6-troubleshooting)

---

## 1. Cek Manual di Browser

### Method 1: View Page Source

**Langkah:**
1. Buka artikel di browser: `http://localhost:8000/artikel/judul-artikel`
2. Klik kanan → **View Page Source** (atau tekan `Ctrl+U` / `Cmd+U`)
3. Cari meta tags dengan `Ctrl+F`:
   - Cari: `citation_`
   - Cari: `DC.`
   - Cari: `og:`
   - Cari: `application/ld+json`

**Yang Harus Ada:**
```html
<!-- Google Scholar -->
<meta name="citation_title" content="...">
<meta name="citation_author" content="...">
<meta name="citation_publication_date" content="...">
<meta name="citation_journal_title" content="...">
<meta name="citation_author_institution" content="...">
<meta name="citation_abstract" content="...">
<meta name="citation_keywords" content="...">
<meta name="citation_fulltext_html_url" content="...">

<!-- Dublin Core -->
<meta name="DC.title" content="...">
<meta name="DC.creator" content="...">
<meta name="DC.date" content="...">

<!-- Schema.org -->
<script type="application/ld+json">
{
  "@type": "ScholarlyArticle",
  ...
}
</script>
```

### Method 2: Browser DevTools

**Langkah:**
1. Buka artikel
2. Tekan `F12` (Developer Tools)
3. Tab **Elements** / **Inspector**
4. Expand `<head>` tag
5. Scroll cari `<meta name="citation_..."`

**Screenshot:**
```
<head>
  <meta charset="UTF-8">
  <meta name="viewport"...>
  ✅ <meta name="citation_title" content="...">
  ✅ <meta name="citation_author" content="...">
  ✅ <meta name="citation_publication_date" content="...">
  ...
</head>
```

---

## 2. Cek dengan Command Line

### Method 1: cURL (Linux/Mac/Windows)

```bash
# Cek semua citation meta tags
curl -s http://localhost:8000/artikel/judul-artikel | grep "citation_"

# Output yang diharapkan:
# <meta name="citation_title" content="...">
# <meta name="citation_author" content="...">
# <meta name="citation_publication_date" content="...">
# ...
```

### Method 2: cURL + grep (Lebih Detail)

```bash
# Cek Google Scholar meta tags
curl -s http://localhost:8000/artikel/judul-artikel | grep -E "citation_|DC\.|og:|application/ld"

# Hitung jumlah meta tags
curl -s http://localhost:8000/artikel/judul-artikel | grep -c "citation_"
# Output: 8 (minimal harus ada 8 citation tags)
```

### Method 3: wget + grep

```bash
# Download HTML dan cek
wget -qO- http://localhost:8000/artikel/judul-artikel | grep "citation_title"

# Output:
# <meta name="citation_title" content="Judul Artikel">
```

### Method 4: Python Script

```python
import requests
from bs4 import BeautifulSoup

url = "http://localhost:8000/artikel/judul-artikel"
response = requests.get(url)
soup = BeautifulSoup(response.content, 'html.parser')

# Cek citation meta tags
citation_tags = soup.find_all('meta', attrs={'name': lambda x: x and x.startswith('citation_')})

print(f"Found {len(citation_tags)} citation meta tags:")
for tag in citation_tags:
    print(f"  - {tag.get('name')}: {tag.get('content')[:50]}...")

# Expected output:
# Found 8 citation meta tags:
#   - citation_title: Judul Artikel...
#   - citation_author: Dr. Ahmad Santoso...
#   - citation_publication_date: 2025/11/12...
```

---

## 3. Cek dengan Online Tools

### Tool 1: Google Scholar Meta Tag Checker

**URL:** https://scholar.google.com/intl/en/scholar/inclusion.html#indexing

**Cara:**
1. Deploy website ke production (HTTPS)
2. Submit URL artikel
3. Google akan crawl dan validasi meta tags

### Tool 2: Structured Data Testing Tool

**URL:** https://search.google.com/test/rich-results

**Cara:**
1. Paste URL artikel atau HTML code
2. Klik "Test URL" atau "Test Code"
3. Lihat hasil validasi Schema.org

**Expected Result:**
```
✅ ScholarlyArticle detected
✅ headline: "Judul Artikel"
✅ author: "Dr. Ahmad Santoso"
✅ datePublished: "2025-11-12"
```

### Tool 3: Meta Tags Checker

**URL:** https://metatags.io/

**Cara:**
1. Paste URL artikel
2. Lihat preview untuk:
   - Google Search
   - Facebook (Open Graph)
   - Twitter Card
   - LinkedIn

### Tool 4: OpenGraph Checker

**URL:** https://www.opengraph.xyz/

**Cara:**
1. Enter URL
2. Cek Open Graph tags
3. Preview tampilan di social media

---

## 4. Cek dengan Browser Extensions

### Extension 1: META SEO Inspector (Chrome/Firefox)

**Install:**
- Chrome: https://chrome.google.com/webstore
- Firefox: https://addons.mozilla.org

**Cara:**
1. Install extension
2. Buka artikel
3. Klik icon extension
4. Lihat semua meta tags

### Extension 2: SEO Meta in 1 Click

**Fitur:**
- ✅ Lihat semua meta tags
- ✅ Check Open Graph
- ✅ Check Twitter Card
- ✅ Check Schema.org

### Extension 3: Detailed SEO Extension

**Fitur:**
- ✅ Meta tags analysis
- ✅ Heading structure
- ✅ Image alt tags
- ✅ Link analysis

---

## 5. Validasi Meta Tags

### Checklist Google Scholar Meta Tags

```
✅ citation_title
✅ citation_author
✅ citation_publication_date
✅ citation_journal_title
✅ citation_author_institution (optional tapi recommended)
✅ citation_abstract (optional tapi recommended)
✅ citation_keywords (optional tapi recommended)
✅ citation_pdf_url (optional tapi sangat recommended)
✅ citation_fulltext_html_url
✅ citation_language
```

### Checklist Dublin Core Meta Tags

```
✅ DC.title
✅ DC.creator
✅ DC.date
✅ DC.identifier
✅ DC.description (optional)
✅ DC.language
✅ DC.type
✅ DC.format
```

### Checklist Open Graph Meta Tags

```
✅ og:title
✅ og:type
✅ og:url
✅ og:image (optional tapi recommended)
✅ og:description (optional)
✅ article:published_time
✅ article:author
```

### Checklist Schema.org JSON-LD

```json
✅ "@context": "https://schema.org"
✅ "@type": "ScholarlyArticle"
✅ "headline": "..."
✅ "author": { "@type": "Person", "name": "..." }
✅ "datePublished": "..."
✅ "abstract": "..." (optional)
✅ "keywords": "..." (optional)
✅ "publisher": { "@type": "Organization", ... }
```

---

## 6. Troubleshooting

### Problem 1: Meta Tags Tidak Muncul

**Cek:**
```bash
# Pastikan view sudah di-clear
php artisan view:clear

# Pastikan cache sudah di-clear
php artisan cache:clear

# Refresh browser dengan hard reload
Ctrl+Shift+R (Windows/Linux)
Cmd+Shift+R (Mac)
```

### Problem 2: Meta Tags Kosong

**Cek:**
```php
// Di resources/views/articles/show.blade.php
@push('head')
@include('articles.partials.meta-tags')
@endpush

// Di resources/views/layouts/app.blade.php
@stack('head')  // Pastikan ada ini di <head>
```

### Problem 3: JSON-LD Error

**Validasi:**
```bash
# Cek JSON syntax
curl -s http://localhost:8000/artikel/judul-artikel | grep -A 20 "application/ld+json" | python -m json.tool

# Jika error, berarti JSON tidak valid
```

### Problem 4: Meta Tags Tidak Ter-index Google Scholar

**Possible Causes:**
1. ❌ Website masih localhost (harus production)
2. ❌ Tidak ada HTTPS (wajib untuk production)
3. ❌ Robots.txt block Googlebot
4. ❌ Meta tags format salah
5. ❌ Artikel belum di-crawl (tunggu 2-4 minggu)

**Solution:**
```bash
# 1. Deploy ke production dengan HTTPS
# 2. Cek robots.txt
curl https://yourdomain.com/robots.txt

# 3. Submit sitemap ke Google Search Console
# 4. Tunggu Google Scholar crawl
```

---

## 📊 Quick Test Script

Simpan sebagai `check-metadata.sh`:

```bash
#!/bin/bash

URL="http://localhost:8000/artikel/penerapan-machine-learning-dalam-prediksi-penyakit-diabetes"

echo "🔍 Checking Meta Data for Google Scholar..."
echo "URL: $URL"
echo ""

echo "📋 Google Scholar Meta Tags:"
curl -s "$URL" | grep -c "citation_" | xargs echo "  Found citation tags:"

echo ""
echo "📋 Dublin Core Meta Tags:"
curl -s "$URL" | grep -c "DC\." | xargs echo "  Found DC tags:"

echo ""
echo "📋 Open Graph Meta Tags:"
curl -s "$URL" | grep -c "og:" | xargs echo "  Found OG tags:"

echo ""
echo "📋 Schema.org JSON-LD:"
curl -s "$URL" | grep -c "application/ld+json" | xargs echo "  Found JSON-LD:"

echo ""
echo "✅ Meta Data Check Complete!"
```

**Run:**
```bash
chmod +x check-metadata.sh
./check-metadata.sh
```

**Expected Output:**
```
🔍 Checking Meta Data for Google Scholar...
URL: http://localhost:8000/artikel/...

📋 Google Scholar Meta Tags:
  Found citation tags: 8

📋 Dublin Core Meta Tags:
  Found DC tags: 8

📋 Open Graph Meta Tags:
  Found OG tags: 7

📋 Schema.org JSON-LD:
  Found JSON-LD: 1

✅ Meta Data Check Complete!
```

---

## 🎯 Summary

**Cara Tercepat:**
1. ✅ View Page Source (`Ctrl+U`)
2. ✅ Search `citation_` (`Ctrl+F`)
3. ✅ Harus ada minimal 8 tags

**Cara Paling Akurat:**
1. ✅ Google Structured Data Testing Tool
2. ✅ Validasi Schema.org
3. ✅ Cek preview di social media

**Untuk Production:**
1. ✅ Deploy dengan HTTPS
2. ✅ Submit ke Google Search Console
3. ✅ Tunggu 2-4 minggu untuk indexing
4. ✅ Cek dengan: `site:yourdomain.com "judul artikel"`

---

**Last Updated**: November 12, 2025
