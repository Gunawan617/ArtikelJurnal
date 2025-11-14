# Testing Checklist - Fitur Diskusi Baru

## Pre-Testing Setup
- [ ] Database migration sudah dijalankan (`php artisan migrate`)
- [ ] Cache sudah di-clear (`php artisan cache:clear`)
- [ ] Ada minimal 2 user untuk testing (1 regular user, 1 admin)

## 1. Close/Open Discussion Feature

### Test Case 1.1: Close Discussion
- [ ] Login sebagai user A
- [ ] Buat diskusi baru
- [ ] Verifikasi tombol "🔒 Tutup" muncul di diskusi
- [ ] Klik tombol "🔒 Tutup"
- [ ] Verifikasi badge "🔒 DITUTUP" muncul di judul diskusi
- [ ] Verifikasi notifikasi kuning muncul: "Diskusi ini telah ditutup..."
- [ ] Verifikasi form reply tidak muncul

### Test Case 1.2: Cannot Reply to Closed Discussion
- [ ] Masih di diskusi yang ditutup
- [ ] Verifikasi tidak ada form reply
- [ ] Login sebagai user B (user lain)
- [ ] Buka diskusi yang ditutup tadi
- [ ] Verifikasi tidak bisa reply

### Test Case 1.3: Reopen Discussion
- [ ] Login kembali sebagai user A (pembuat diskusi)
- [ ] Buka diskusi yang ditutup
- [ ] Klik tombol "🔓 Buka"
- [ ] Verifikasi badge "DITUTUP" hilang
- [ ] Verifikasi form reply muncul kembali
- [ ] Coba reply - harus berhasil

### Test Case 1.4: Badge in Discussion List
- [ ] Buka halaman `/diskusi`
- [ ] Tutup salah satu diskusi
- [ ] Kembali ke halaman `/diskusi`
- [ ] Verifikasi badge "🔒 DITUTUP" muncul di list

## 2. Auto-Approve Comments Feature

### Test Case 2.1: Direct Comment Approval
- [ ] Login sebagai user
- [ ] Buka diskusi yang terbuka
- [ ] Tulis balasan
- [ ] Submit balasan
- [ ] Verifikasi balasan langsung muncul (tidak perlu approve admin)

### Test Case 2.2: Nested Reply
- [ ] Reply ke balasan yang sudah ada
- [ ] Verifikasi nested reply langsung muncul

## 3. Report System

### Test Case 3.1: Report Discussion
- [ ] Login sebagai user A
- [ ] Buka diskusi dari user B
- [ ] Klik tombol "🚩 Laporkan"
- [ ] Verifikasi modal report muncul
- [ ] Isi alasan laporan (minimal beberapa kata)
- [ ] Submit laporan
- [ ] Verifikasi muncul notifikasi sukses

### Test Case 3.2: Report Reply
- [ ] Masih sebagai user A
- [ ] Cari balasan dari user B
- [ ] Klik tombol "🚩" di balasan
- [ ] Isi alasan dan submit
- [ ] Verifikasi sukses

### Test Case 3.3: Cannot Report Own Content
- [ ] Buka diskusi/balasan sendiri
- [ ] Verifikasi tombol "🚩 Laporkan" tidak muncul
- [ ] Hanya tombol "Hapus" yang muncul

### Test Case 3.4: Duplicate Report Prevention
- [ ] Report diskusi yang sama 2x
- [ ] Verifikasi muncul error: "Anda sudah melaporkan konten ini"

### Test Case 3.5: Admin View Reports
- [ ] Login sebagai admin
- [ ] Buka panel admin Filament
- [ ] Klik menu "Laporan User" (di grup Moderasi)
- [ ] Verifikasi laporan yang dibuat tadi muncul
- [ ] Verifikasi kolom: Pelapor, User Dilaporkan, Tipe, Alasan, Status, Tanggal

### Test Case 3.6: Admin Review Report
- [ ] Masih di panel admin
- [ ] Klik "View" pada salah satu laporan
- [ ] Verifikasi detail laporan lengkap
- [ ] Klik "Edit"
- [ ] Ubah status ke "Reviewed"
- [ ] Tambahkan catatan admin
- [ ] Save
- [ ] Verifikasi perubahan tersimpan

## 4. Ban/Unban System

### Test Case 4.1: Ban User from Report
- [ ] Login sebagai admin
- [ ] Buka "Laporan User"
- [ ] Pilih laporan dengan status "pending"
- [ ] Klik action "Ban User"
- [ ] Isi alasan ban
- [ ] Konfirmasi
- [ ] Verifikasi user ter-ban
- [ ] Verifikasi status laporan berubah ke "resolved"

### Test Case 4.2: Ban User from User Management
- [ ] Masih sebagai admin
- [ ] Buka menu "Kelola User"
- [ ] Pilih user yang belum di-ban
- [ ] Klik action "Ban"
- [ ] Isi alasan ban
- [ ] Konfirmasi
- [ ] Verifikasi kolom "Status" berubah jadi "Banned"

### Test Case 4.3: Banned User Cannot Login
- [ ] Logout dari admin
- [ ] Coba login sebagai user yang di-ban
- [ ] Verifikasi login gagal
- [ ] Verifikasi muncul pesan error dengan alasan ban

### Test Case 4.4: Banned User Cannot Create Discussion
- [ ] Jika user yang di-ban masih login (sebelum middleware aktif)
- [ ] Coba akses `/diskusi/buat`
- [ ] Verifikasi otomatis logout atau redirect dengan error

### Test Case 4.5: Banned User Cannot Reply
- [ ] User yang di-ban coba reply diskusi
- [ ] Verifikasi muncul error atau otomatis logout

### Test Case 4.6: Unban User
- [ ] Login sebagai admin
- [ ] Buka "Kelola User"
- [ ] Pilih user yang di-ban
- [ ] Klik action "Unban"
- [ ] Konfirmasi
- [ ] Verifikasi status kembali "Aktif"
- [ ] Logout dan login sebagai user yang di-unban
- [ ] Verifikasi bisa login dan akses normal

## 5. Integration Tests

### Test Case 5.1: Close + Report
- [ ] User A tutup diskusinya
- [ ] User B coba report diskusi yang ditutup
- [ ] Verifikasi report tetap bisa dilakukan

### Test Case 5.2: Ban + Existing Content
- [ ] User A buat diskusi dan beberapa reply
- [ ] Admin ban user A
- [ ] Verifikasi diskusi dan reply user A masih ada
- [ ] Verifikasi user A tidak bisa login

### Test Case 5.3: Report + Ban + Unban
- [ ] User A report user B
- [ ] Admin ban user B dari laporan
- [ ] Admin unban user B
- [ ] User B login kembali
- [ ] Verifikasi user B bisa akses normal

## 6. UI/UX Tests

### Test Case 6.1: Responsive Design
- [ ] Test semua fitur di mobile view
- [ ] Test modal report di mobile
- [ ] Test badge "DITUTUP" di mobile

### Test Case 6.2: Button Visibility
- [ ] Verifikasi tombol close hanya muncul untuk pembuat diskusi
- [ ] Verifikasi tombol report tidak muncul untuk konten sendiri
- [ ] Verifikasi tombol hapus hanya untuk pemilik konten

### Test Case 6.3: Notifications
- [ ] Verifikasi notifikasi sukses muncul saat close/open
- [ ] Verifikasi notifikasi sukses muncul saat report
- [ ] Verifikasi notifikasi error muncul saat banned user coba akses

## 7. Security Tests

### Test Case 7.1: Authorization
- [ ] User A coba close diskusi user B (via direct URL/API)
- [ ] Verifikasi gagal dengan error 403

### Test Case 7.2: CSRF Protection
- [ ] Verifikasi semua form punya @csrf token
- [ ] Coba submit form tanpa token (via curl/postman)
- [ ] Verifikasi gagal

### Test Case 7.3: SQL Injection
- [ ] Coba input SQL injection di form report
- [ ] Verifikasi tidak ada error dan data ter-escape

## 8. Performance Tests

### Test Case 8.1: Large Discussion
- [ ] Buat diskusi dengan 50+ replies
- [ ] Verifikasi loading time masih acceptable
- [ ] Verifikasi pagination berfungsi

### Test Case 8.2: Many Reports
- [ ] Buat 20+ laporan
- [ ] Buka panel admin "Laporan User"
- [ ] Verifikasi loading cepat
- [ ] Verifikasi filter dan search berfungsi

## Summary Checklist

- [ ] Semua fitur close/open berfungsi
- [ ] Auto-approve comment aktif
- [ ] Report system lengkap
- [ ] Ban/unban berfungsi sempurna
- [ ] Middleware proteksi aktif
- [ ] UI/UX responsif dan user-friendly
- [ ] Security terjaga
- [ ] Performance acceptable

## Notes
- Catat semua bug yang ditemukan
- Screenshot untuk bug report
- Test di browser berbeda (Chrome, Firefox, Safari)
- Test dengan user role berbeda (admin, pembaca)
