# Changelog - Fitur Diskusi

## [2.0.0] - 2025-11-14

### ✨ Added

#### Close/Open Discussion
- Pembuat diskusi dapat menutup diskusi mereka sendiri
- Tombol toggle "🔒 Tutup" / "🔓 Buka" di halaman detail diskusi
- Badge "🔒 DITUTUP" muncul di diskusi yang ditutup (list & detail)
- Notifikasi kuning saat diskusi ditutup
- Form reply otomatis disembunyikan saat diskusi ditutup
- Validasi backend untuk mencegah reply ke diskusi yang ditutup

#### Auto-Approve Comments
- Semua balasan diskusi langsung ditampilkan tanpa perlu approve admin
- Menghapus bottleneck approval untuk meningkatkan engagement
- Admin fokus pada moderasi melalui sistem report

#### Report System
- User dapat melaporkan diskusi atau balasan yang tidak pantas
- Tombol "🚩 Laporkan" di setiap diskusi dan balasan
- Modal report dengan form alasan laporan
- Validasi untuk mencegah duplicate report
- User tidak bisa melaporkan konten sendiri
- Tabel baru `user_reports` untuk menyimpan laporan
- Model `UserReport` dengan relasi lengkap

#### Ban/Unban System
- Admin dapat ban/unban user dari panel Filament
- Kolom baru di tabel `users`: `is_banned`, `banned_at`, `ban_reason`
- User yang di-ban:
  - Otomatis logout saat akses sistem
  - Tidak bisa login kembali
  - Tidak bisa membuat diskusi baru
  - Tidak bisa membalas diskusi
  - Tidak bisa melaporkan konten
- Middleware `CheckBannedUser` untuk proteksi global
- Action "Ban" dan "Unban" di Filament UserResource
- Action "Ban User" langsung dari laporan di Filament

#### Admin Panel
- Menu baru "Laporan User" di grup "Moderasi"
- Filament Resource `UserReportResource` dengan:
  - List view dengan filter status
  - View page dengan detail lengkap laporan
  - Edit page untuk update status dan catatan admin
  - Action "Ban User" untuk ban langsung dari laporan
- Update `UserResource` dengan:
  - Kolom "Status" (Aktif/Banned)
  - Action "Ban" untuk user aktif
  - Action "Unban" untuk user yang di-ban

### 🔧 Changed

#### Controllers
- `DiscussionController@reply`: Tambah validasi untuk diskusi tertutup dan user banned
- `DiscussionController@store`: Tambah validasi untuk user banned
- `DiscussionController@toggleClose`: Method baru untuk toggle status diskusi

#### Models
- `Discussion`: Tambah field `is_closed` dan relasi `reports()`
- `DiscussionReply`: Tambah relasi `reports()`
- `User`: Tambah field `is_banned`, `banned_at`, `ban_reason`

#### Views
- `discussions/show.blade.php`:
  - Tambah badge "DITUTUP" di judul
  - Tambah notifikasi untuk diskusi tertutup
  - Tambah tombol close/open untuk pembuat diskusi
  - Tambah tombol report untuk semua user
  - Tambah modal report
  - Conditional form reply berdasarkan status diskusi
- `discussions/index.blade.php`:
  - Tambah badge "DITUTUP" di list diskusi

#### Routes
- `POST /diskusi/{id}/toggle-close`: Route baru untuk toggle close
- `POST /report`: Route baru untuk submit laporan

#### Middleware
- Tambah `CheckBannedUser` middleware ke web middleware group
- Otomatis cek dan logout user yang di-ban

### 📁 New Files

#### Migrations
- `2025_11_14_064259_add_discussion_features.php`
- `2025_11_14_064304_create_user_reports_table.php`

#### Models
- `app/Models/UserReport.php`

#### Controllers
- `app/Http/Controllers/UserReportController.php`

#### Middleware
- `app/Http/Middleware/CheckBannedUser.php`

#### Filament Resources
- `app/Filament/Resources/UserReportResource.php`
- `app/Filament/Resources/UserReportResource/Pages/ViewUserReport.php`
- `app/Filament/Resources/UserReportResource/Pages/EditUserReport.php`
- `app/Filament/Resources/UserReportResource/Pages/ListUserReports.php`
- `app/Filament/Resources/UserReportResource/Pages/CreateUserReport.php`

#### Documentation
- `DISCUSSION_FEATURES.md` - Dokumentasi lengkap fitur
- `DISCUSSION_FEATURES_SUMMARY.md` - Summary singkat
- `TESTING_CHECKLIST.md` - Checklist untuk testing
- `QUICK_REFERENCE.md` - Quick reference guide
- `CHANGELOG_DISCUSSION.md` - File ini

### 🔒 Security

- CSRF protection di semua form
- Authorization check untuk close discussion (hanya pembuat)
- Authorization check untuk delete discussion/reply (hanya pemilik)
- Middleware proteksi untuk user banned
- Validasi input di semua endpoint
- Prevent duplicate report
- Prevent self-report

### 🐛 Bug Fixes

- N/A (fitur baru)

### 🗑️ Removed

- N/A

### ⚠️ Breaking Changes

- N/A (backward compatible)

### 📊 Database Changes

#### Table: discussions
```sql
ALTER TABLE discussions ADD COLUMN is_closed BOOLEAN DEFAULT false;
```

#### Table: users
```sql
ALTER TABLE users ADD COLUMN is_banned BOOLEAN DEFAULT false;
ALTER TABLE users ADD COLUMN banned_at TIMESTAMP NULL;
ALTER TABLE users ADD COLUMN ban_reason TEXT NULL;
```

#### Table: user_reports (NEW)
```sql
CREATE TABLE user_reports (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    reporter_id BIGINT NOT NULL,
    reported_user_id BIGINT NOT NULL,
    reportable_type VARCHAR(255) NOT NULL,
    reportable_id BIGINT NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('pending', 'reviewed', 'resolved') DEFAULT 'pending',
    admin_notes TEXT NULL,
    reviewed_by BIGINT NULL,
    reviewed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reported_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_reportable (reportable_type, reportable_id),
    INDEX idx_status (status, created_at)
);
```

### 📝 Migration Guide

1. **Backup database** sebelum migrate
2. Jalankan migration:
   ```bash
   php artisan migrate
   ```
3. Clear cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```
4. Test fitur baru sesuai `TESTING_CHECKLIST.md`

### 🎯 Next Steps (Future)

- [ ] Email notification untuk admin saat ada laporan baru
- [ ] Dashboard statistik laporan
- [ ] Auto-ban berdasarkan threshold laporan
- [ ] Appeal system untuk user yang di-ban
- [ ] Report history per user
- [ ] Soft delete untuk konten yang dilaporkan
- [ ] Webhook notification untuk moderator
- [ ] Rate limiting untuk report (prevent spam)

### 👥 Contributors

- Developer: [Your Name]
- Date: 2025-11-14

### 📞 Support

Untuk pertanyaan atau issue:
- Baca dokumentasi di `DISCUSSION_FEATURES.md`
- Cek troubleshooting di `QUICK_REFERENCE.md`
- Lihat testing checklist di `TESTING_CHECKLIST.md`

---

## [1.0.0] - 2025-11-12

### Initial Release
- Basic discussion system
- Create, read, delete discussions
- Reply to discussions
- Nested replies
- Search and filter discussions
- Related discussions by keywords
