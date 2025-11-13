# 🔐 Login Credentials

## Admin Panel (Filament)
**URL**: http://localhost:8000/admin

**Email**: admin@scholar.com  
**Password**: admin123

**Akses**:
- Manage semua artikel
- Manage semua user
- Manage semua diskusi
- Full admin access

---

## Dosen Account
**URL**: http://localhost:8000/login

**Email**: ahmad.santoso@university.ac.id  
**Password**: dosen123

**Akses**:
- Buat artikel ilmiah
- Edit artikel sendiri
- Balas diskusi
- Upload file PDF
- **Update profile sendiri** (Menu: Profile Saya)

---

## Database MySQL
**Host**: 127.0.0.1  
**Port**: 3306  
**Database**: scholar_system  
**Username**: root  
**Password**: (kosong)

---

## Data Summary
- **Total Artikel**: 14
- **Teknologi**: 3 artikel (1 featured)
- **Kesehatan**: 3 artikel
- **Lingkungan**: 2 artikel
- **Pendidikan**: 2 artikel
- **Keamanan**: 2 artikel
- **Sosial**: 2 artikel

---

## Quick Start
```bash
# Start development server
php artisan serve

# Access website
http://localhost:8000

# Access admin panel
http://localhost:8000/admin
```

## Cara Update Profile (Dosen)
1. Login ke admin panel: http://localhost:8000/admin
2. Klik menu **"Profile Saya"** di sidebar (paling bawah)
3. Isi informasi profile:
   - Nama Lengkap
   - Gelar (Dr., Prof., M.Kom, dll)
   - Institusi (Universitas / Lembaga)
   - Bio (Deskripsi singkat)
   - Foto Profil
4. Klik **"Simpan Perubahan"**
5. Sekarang saat buat artikel baru, data penulis otomatis terisi!

---

## Notes
- Password dapat diubah melalui admin panel
- Untuk production, ganti semua password dengan yang lebih kuat
- Jangan commit file ini ke repository public
