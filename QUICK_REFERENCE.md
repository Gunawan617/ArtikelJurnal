# Quick Reference - Fitur Diskusi Baru

## 🚀 Quick Start

### Untuk User Biasa:

**Menutup Diskusi:**
1. Buka diskusi yang Anda buat
2. Klik tombol "🔒 Tutup" di pojok kanan atas
3. Diskusi tidak bisa dibalas lagi

**Membuka Diskusi:**
1. Buka diskusi yang sudah ditutup
2. Klik tombol "🔓 Buka"
3. Diskusi bisa dibalas lagi

**Melaporkan Konten:**
1. Klik tombol "🚩 Laporkan" di diskusi/balasan
2. Isi alasan laporan
3. Klik "Kirim Laporan"

### Untuk Admin:

**Melihat Laporan:**
1. Login ke panel admin (`/admin`)
2. Klik menu "Laporan User" (grup Moderasi)
3. Lihat semua laporan yang masuk

**Ban User:**
- **Dari Laporan:**
  1. Buka "Laporan User"
  2. Klik action "Ban User" pada laporan
  3. Isi alasan ban
  
- **Dari User Management:**
  1. Buka "Kelola User"
  2. Klik action "Ban" pada user
  3. Isi alasan ban

**Unban User:**
1. Buka "Kelola User"
2. Klik action "Unban" pada user yang di-ban
3. Konfirmasi

## 📋 Routes

```
GET    /diskusi                      - List diskusi
GET    /diskusi/buat                 - Form buat diskusi
POST   /diskusi                      - Simpan diskusi
GET    /diskusi/{id}                 - Detail diskusi
POST   /diskusi/{id}/balas           - Balas diskusi
POST   /diskusi/{id}/toggle-close    - Tutup/buka diskusi
DELETE /diskusi/{id}                 - Hapus diskusi
DELETE /diskusi/balasan/{id}         - Hapus balasan
POST   /report                       - Kirim laporan

GET    /admin/user-reports           - List laporan (admin)
GET    /admin/user-reports/{id}      - Detail laporan (admin)
GET    /admin/users                  - Kelola user (admin)
```

## 🗄️ Database Schema

### discussions
```
is_closed: boolean (default: false)
```

### users
```
is_banned: boolean (default: false)
banned_at: timestamp (nullable)
ban_reason: text (nullable)
```

### user_reports (NEW)
```
id: bigint
reporter_id: bigint (FK users)
reported_user_id: bigint (FK users)
reportable_type: string (Discussion/DiscussionReply)
reportable_id: bigint
reason: text
status: enum (pending/reviewed/resolved)
admin_notes: text (nullable)
reviewed_by: bigint (FK users, nullable)
reviewed_at: timestamp (nullable)
created_at: timestamp
updated_at: timestamp
```

## 🔐 Permissions

### User Biasa:
- ✅ Buat diskusi
- ✅ Balas diskusi (jika tidak ditutup)
- ✅ Tutup/buka diskusi sendiri
- ✅ Hapus diskusi/balasan sendiri
- ✅ Laporkan konten orang lain
- ❌ Tidak bisa laporkan konten sendiri
- ❌ Tidak bisa tutup diskusi orang lain

### User yang Di-ban:
- ❌ Tidak bisa login
- ❌ Tidak bisa buat diskusi
- ❌ Tidak bisa balas diskusi
- ❌ Tidak bisa laporkan konten

### Admin:
- ✅ Semua akses user biasa
- ✅ Lihat semua laporan
- ✅ Ban/unban user
- ✅ Edit status laporan
- ✅ Tambah catatan admin

## 🎨 UI Elements

### Badge "DITUTUP"
```html
<span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded">
    🔒 DITUTUP
</span>
```

### Tombol Close/Open
```html
<!-- Close -->
<button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
    🔒 Tutup
</button>

<!-- Open -->
<button class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
    🔓 Buka
</button>
```

### Tombol Report
```html
<button class="text-orange-600 hover:text-orange-800 text-sm">
    🚩 Laporkan
</button>
```

## 🔧 Troubleshooting

### User tidak bisa login setelah di-ban
✅ **Normal behavior** - User yang di-ban memang tidak bisa login

### Diskusi tidak bisa ditutup
- Pastikan Anda adalah pembuat diskusi
- Cek apakah tombol "🔒 Tutup" muncul
- Cek console browser untuk error

### Laporan tidak muncul di admin panel
- Pastikan login sebagai admin
- Cek menu "Laporan User" di grup "Moderasi"
- Refresh halaman

### Form reply masih muncul di diskusi yang ditutup
- Clear cache browser
- Hard refresh (Ctrl+Shift+R)
- Cek database: `SELECT is_closed FROM discussions WHERE id = ?`

### User masih bisa login setelah di-ban
- Clear cache: `php artisan cache:clear`
- Cek middleware di `bootstrap/app.php`
- Cek database: `SELECT is_banned FROM users WHERE id = ?`

## 📝 Code Examples

### Check if discussion is closed (Blade)
```blade
@if($discussion->is_closed)
    <p>Diskusi ditutup</p>
@endif
```

### Check if user is banned (Controller)
```php
if (auth()->user()->is_banned) {
    return back()->with('error', 'Akun Anda di-ban');
}
```

### Create report (Controller)
```php
UserReport::create([
    'reporter_id' => auth()->id(),
    'reported_user_id' => $reportedUserId,
    'reportable_type' => Discussion::class,
    'reportable_id' => $discussionId,
    'reason' => $request->reason,
    'status' => 'pending',
]);
```

### Ban user (Filament)
```php
$user->update([
    'is_banned' => true,
    'banned_at' => now(),
    'ban_reason' => $reason,
]);
```

## 📚 Related Files

- **Documentation:** `DISCUSSION_FEATURES.md`
- **Summary:** `DISCUSSION_FEATURES_SUMMARY.md`
- **Testing:** `TESTING_CHECKLIST.md`
- **Controllers:** `app/Http/Controllers/DiscussionController.php`
- **Models:** `app/Models/Discussion.php`, `app/Models/UserReport.php`
- **Views:** `resources/views/discussions/show.blade.php`
- **Migrations:** `database/migrations/2025_11_14_*`

## 🆘 Support

Jika ada masalah:
1. Cek file `TROUBLESHOOTING.md`
2. Cek log Laravel: `storage/logs/laravel.log`
3. Cek console browser (F12)
4. Jalankan: `php artisan cache:clear && php artisan config:clear`
