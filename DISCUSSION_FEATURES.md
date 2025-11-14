# Fitur Diskusi - Update Terbaru

## Fitur yang Ditambahkan

### 1. Close/Open Discussion
- **Pembuat diskusi** dapat menutup diskusi mereka sendiri
- Diskusi yang ditutup akan menampilkan badge "🔒 DITUTUP" 
- Ketika diskusi ditutup, tidak ada yang bisa menambahkan balasan baru
- Pembuat diskusi dapat membuka kembali diskusi yang sudah ditutup

**Cara Menggunakan:**
- Di halaman detail diskusi, pembuat diskusi akan melihat tombol "🔒 Tutup" atau "🔓 Buka"
- Klik tombol tersebut untuk toggle status diskusi

### 2. Auto-Approve Comments
- **Semua komentar/balasan langsung ditampilkan** tanpa perlu approve admin
- User dapat langsung berinteraksi dalam diskusi
- Admin fokus pada moderasi dan pengelolaan laporan

### 3. Report System
- **Semua user** dapat melaporkan diskusi atau balasan yang tidak pantas
- Tombol "🚩 Laporkan" tersedia di setiap diskusi dan balasan
- User harus memberikan alasan saat melaporkan

**Cara Melaporkan:**
1. Klik tombol "🚩 Laporkan" pada diskusi/balasan
2. Isi alasan laporan
3. Klik "Kirim Laporan"
4. Admin akan meninjau laporan

### 4. Ban/Unban System
- **Admin** dapat ban/unban user dari panel admin
- User yang di-ban:
  - Tidak bisa login
  - Tidak bisa membuat diskusi baru
  - Tidak bisa membalas diskusi
  - Tidak bisa melaporkan konten

**Cara Ban User (Admin):**
1. Masuk ke panel admin Filament
2. Buka menu "Kelola User" atau "Laporan User"
3. Klik tombol "Ban" pada user yang ingin di-ban
4. Isi alasan ban
5. Konfirmasi

**Cara Unban User (Admin):**
1. Masuk ke panel admin Filament
2. Buka menu "Kelola User"
3. Klik tombol "Unban" pada user yang di-ban
4. Konfirmasi

## Panel Admin

### Menu Baru: "Laporan User"
- Menampilkan semua laporan dari user
- Filter berdasarkan status: Pending, Reviewed, Resolved
- Admin dapat:
  - Melihat detail laporan
  - Menambahkan catatan admin
  - Mengubah status laporan
  - Ban user langsung dari laporan

### Update Menu: "Kelola User"
- Kolom baru: Status (Aktif/Banned)
- Tombol "Ban" untuk user yang aktif
- Tombol "Unban" untuk user yang di-ban

## Database Changes

### Tabel Baru: `user_reports`
- `reporter_id` - User yang melaporkan
- `reported_user_id` - User yang dilaporkan
- `reportable_type` - Tipe konten (Discussion/DiscussionReply)
- `reportable_id` - ID konten
- `reason` - Alasan laporan
- `status` - Status: pending, reviewed, resolved
- `admin_notes` - Catatan dari admin
- `reviewed_by` - Admin yang meninjau
- `reviewed_at` - Waktu ditinjau

### Update Tabel: `discussions`
- `is_closed` - Status diskusi (open/closed)

### Update Tabel: `users`
- `is_banned` - Status ban
- `banned_at` - Waktu di-ban
- `ban_reason` - Alasan ban

## Routes Baru

```php
// Close/Open discussion
POST /diskusi/{id}/toggle-close

// Report content
POST /report
```

## Middleware

### CheckBannedUser
- Otomatis logout user yang di-ban
- Mencegah user yang di-ban mengakses sistem
- Diterapkan ke semua route web

## Testing

Untuk test fitur-fitur ini:

1. **Test Close Discussion:**
   - Login sebagai user
   - Buat diskusi baru
   - Tutup diskusi
   - Coba balas diskusi (harus gagal)
   - Buka kembali diskusi

2. **Test Report:**
   - Login sebagai user A
   - Laporkan diskusi/balasan dari user B
   - Login sebagai admin
   - Cek laporan di panel admin

3. **Test Ban/Unban:**
   - Login sebagai admin
   - Ban user dari panel admin
   - Logout dan coba login sebagai user yang di-ban (harus gagal)
   - Unban user
   - Login kembali (harus berhasil)

## Notes

- User yang di-ban akan otomatis logout dan tidak bisa login kembali
- Diskusi yang ditutup tetap bisa dilihat, hanya tidak bisa dibalas
- Laporan yang sudah resolved tidak bisa diubah lagi
- Admin tidak bisa di-ban oleh admin lain
