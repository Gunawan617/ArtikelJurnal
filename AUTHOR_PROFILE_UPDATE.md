# 📝 Update: Author Profile System

## Perubahan

Informasi penulis artikel sekarang **otomatis diambil dari profile user**, tidak perlu diisi manual setiap kali buat artikel.

## ✅ Keuntungan

1. **Lebih Efisien**: Tidak perlu isi data penulis berulang-ulang
2. **Konsisten**: Data penulis selalu sama di semua artikel
3. **Mudah Update**: Update profile sekali, semua artikel baru akan menggunakan data terbaru
4. **Best Practice**: Sesuai dengan sistem CMS modern (WordPress, Medium, dll)

## 🔄 Cara Kerja

### 1. Update Profile User
**Admin Panel** → **Kelola User** → **Edit User**

Field profile yang tersedia:
- **Nama Lengkap** (required)
- **Gelar**: Dr., Prof., M.Kom, dll
- **Institusi**: Universitas / Lembaga
- **Bio**: Deskripsi singkat tentang penulis
- **Foto Profil**: Upload foto

### 2. Buat Artikel Baru
Saat membuat artikel baru, informasi penulis akan **otomatis terisi** dari profile user yang login:
- `author` ← `user.name`
- `author_title` ← `user.title`
- `author_institution` ← `user.institution`
- `author_bio` ← `user.bio`
- `author_photo` ← `user.photo`

### 3. Tampilan di Form Artikel
Form artikel sekarang menampilkan:
```
Informasi Penulis
Dr. Ahmad Santoso, M.Kom (Dr., M.Kom) - Universitas Indonesia
ℹ️ Informasi penulis diambil dari profile Anda. Update di menu Profile untuk mengubah.
```

## 📊 Database Changes

### New Migration: `add_profile_fields_to_users_table`
Menambahkan kolom ke tabel `users`:
- `title` (string, nullable) - Gelar
- `institution` (string, nullable) - Institusi
- `bio` (text, nullable) - Bio singkat
- `photo` (string, nullable) - Path foto profil

### Existing Columns in `articles` table:
- `author` - Nama penulis (auto-filled)
- `author_title` - Gelar (auto-filled)
- `author_institution` - Institusi (auto-filled)
- `author_bio` - Bio (auto-filled)
- `author_photo` - Foto (auto-filled)

## 🎯 Workflow

```
1. Admin/Dosen login
2. Update profile di menu "Kelola User"
3. Buat artikel baru
4. Data penulis otomatis terisi dari profile
5. Fokus ke konten artikel saja
```

## 📝 Notes

- **Artikel lama**: Tetap menggunakan data yang sudah tersimpan
- **Artikel baru**: Menggunakan data profile saat artikel dibuat
- **Update profile**: Hanya mempengaruhi artikel baru, tidak mengubah artikel lama
- **Fleksibilitas**: Jika perlu, admin bisa edit data penulis di artikel secara manual

## 🔐 Permissions

- **Admin**: Bisa edit profile semua user
- **Dosen**: Bisa edit profile sendiri (coming soon: profile page)
- **Pembaca**: Tidak perlu profile penulis

## 🚀 Next Steps

1. ✅ Migration profile fields
2. ✅ Update UserResource form
3. ✅ Auto-fill di CreateArticle
4. ⏳ Buat halaman "My Profile" untuk dosen
5. ⏳ Tampilkan author card di artikel detail

---

**Updated**: November 12, 2025
