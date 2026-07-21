# 🎓 Sistem Informasi Jadwal Perkuliahan

**Sistem Informasi Jadwal Perkuliahan (Academic Schedule Information System)** adalah aplikasi berbasis web yang dikembangkan menggunakan framework Laravel untuk mengelola dan menampilkan jadwal perkuliahan secara real-time. Sistem ini menyediakan landing page publik untuk menampilkan jadwal serta panel admin yang lengkap untuk manajemen data.

---

## 📋 Daftar Isi

- [Product Requirements Document (PRD)](#product-requirements-document-prd)
  - [1. Pendahuluan](#1-pendahuluan)
  - [2. Tujuan Produk](#2-tujuan-produk)
  - [3. Target Pengguna](#3-target-pengguna)
  - [4. Fitur & Fungsionalitas](#4-fitur--fungsionalitas)
  - [5. Arsitektur Sistem](#5-arsitektur-sistem)
  - [6. Struktur Basis Data](#6-struktur-basis-data)
  - [7. Teknologi yang Digunakan](#7-teknologi-yang-digunakan)
  - [8. Roles & Permission](#8-roles--permission)
  - [9. Alur Sistem](#9-alur-sistem)
  - [10. Keamanan](#10-keamanan)
  - [11. Non-Fungsional Requirements](#11-non-fungsional-requirements)
  - [12. Milestone & Pengembangan](#12-milestone--pengembangan)
- [Panduan Instalasi](#panduan-instalasi)
- [Lingkungan Pengembangan](#lingkungan-pengembangan)

---

## Product Requirements Document (PRD)

### 1. Pendahuluan

#### 1.1 Latar Belakang

Sistem Informasi Jadwal Perkuliahan dibangun untuk menggantikan penyebaran jadwal kuliah yang masih bersifat statis (cetak/file PDF) dengan sistem yang dinamis, real-time, dan dapat diakses kapan saja oleh mahasiswa dan dosen. Sistem ini dirancang untuk institusi pendidikan tinggi seperti politeknik atau universitas.

#### 1.2 Tujuan

- Menyediakan informasi jadwal perkuliahan yang *real-time* dan akurat
- Memudahkan admin dalam mengelola data jadwal secara terpusat
- Memberikan fleksibilitas tampilan jadwal berdasarkan kelas, hari, dan semester
- Menyediakan fitur kritik dan saran untuk perbaikan layanan
- Mendukung backup data dan pemeliharaan sistem

#### 1.3 Scope

**In Scope:**
- Landing page publik untuk menampilkan jadwal perkuliahan
- Panel admin untuk CRUD jadwal, ruangan, semester, dan pengguna
- Sistem autentikasi dengan role superadmin dan admin
- Manajemen semester aktif
- Mode maintenance untuk landing page
- Backup database (mysqldump & PHP fallback)
- Ekspor laporan jadwal (PDF & CSV)
- Sistem kritik & saran dari pengunjung
- Email verifikasi untuk superadmin
- Fitur *running text* di landing page
- Auto logout session timeout
- Activity logging

**Out of Scope:**
- Integrasi dengan SIAKAD (Sistem Informasi Akademik)
- Aplikasi mobile native
- Fitur presensi mahasiswa
- Input nilai mahasiswa

---

### 2. Tujuan Produk

| Tujuan | Deskripsi |
|--------|-----------|
| **Aksesibilitas** | Jadwal perkuliahan dapat diakses publik tanpa login |
| **Akurasi** | Jadwal selalu *up-to-date* sesuai semester aktif |
| **Efisiensi** | Admin dapat mengelola data dengan bulk insert dan export |
| **Keamanan** | Sistem login aman dengan proteksi brute force |
| **Maintainability** | Mode maintenance, backup, dan logging aktivitas |

---

### 3. Target Pengguna

| Pengguna | Deskripsi | Kebutuhan Utama |
|----------|-----------|-----------------|
| **Mahasiswa & Umum** | Pengunjung landing page | Melihat jadwal, filter kelas/hari, melihat info ruangan, mengirim saran |
| **Admin** | Staf administrasi akademik | CRUD jadwal, kelola ruangan, lihat saran, ubah password sendiri |
| **Superadmin** | Administrator sistem | Semua akses admin + kelola pengguna, reset data, backup DB, pengaturan sistem, ubah password any user |

---

### 4. Fitur & Fungsionalitas

#### 4.1 Landing Page (Publik)

| Fitur | Deskripsi | Prioritas |
|-------|-----------|-----------|
| **Tampilan Jadwal** | Menampilkan jadwal berdasarkan hari dan kelas yang dipilih | P0 |
| **Semua Hari / Semua Kelas** | Mode tampilan jadwal untuk semua hari atau semua kelas | P1 |
| **Jadwal Berlangsung** | Menampilkan jadwal yang sedang berlangsung secara real-time | P1 |
| **Jadwal Berikutnya** | Menampilkan jadwal selanjutnya beserta *countdown* waktu tunggu | P1 |
| **Filter Semester** | Dropdown untuk memilih tahun akademik/semester | P0 |
| **Running Text** | Teks berjalan dengan kecepatan/warna yang dapat dikonfigurasi | P2 |
| **Pop-up Ruangan** | Menampilkan foto dan detail ruangan saat diklik | P1 |
| **Kritik & Saran** | Form untuk mengirim saran (nama, email, pesan) | P1 |
| **Kontak Admin** | Menampilkan daftar admin yang bisa dihubungi | P2 |
| **Mode Maintenance** | Halaman *under maintenance* jika diaktifkan admin | P1 |

#### 4.2 Panel Admin - Dashboard

| Fitur | Deskripsi |
|-------|-----------|
| **Statistik** | Total jadwal, ruangan, kelas, saran, saran pending |
| **Status Maintenance** | Indikator apakah mode maintenance aktif |
| **Aktivitas Terbaru** | 10 aktivitas terakhir dari activity_logs |

#### 4.3 Panel Admin - Manajemen Jadwal

| Fitur | Deskripsi |
|-------|-----------|
| **Tambah Jadwal** | Form input jadwal dengan validasi bentrok |
| **Edit Jadwal** | Update data jadwal dengan validasi bentrok |
| **Hapus Jadwal** | Hapus satu jadwal |
| **Hapus Semua Jadwal** | Hapus seluruh data jadwal (superadmin only) |
| **Tambah Massal** | Bulk insert multiple schedules sekaligus |
| **Cek Bentrok** | Mendeteksi bentrok: kelas yang sama, ruangan yang sama, dan dosen yang sama dalam waktu yang tumpang tindih |
| **Filter** | Filter berdasarkan tahun akademik dan semester |
| **Time Slots** | 10 slot waktu otomatis (07:30 - 16:30) |

#### 4.4 Panel Admin - Manajemen Ruangan

| Fitur | Deskripsi |
|-------|-----------|
| **Tambah Ruangan** | Data: nama, kapasitas, fasilitas, deskripsi, foto |
| **Edit Ruangan** | Update data + upload/ganti foto |
| **Hapus Ruangan** | Hapus data + foto dari storage |
| **Hapus Foto** | Hapus foto tanpa menghapus data ruangan |
| **Upload Foto** | Format: jpeg,png,gif,webp, max 2MB |
| **Statistik** | Total ruangan, dengan foto, total kapasitas, ruangan terpakai |

#### 4.5 Panel Admin - Manajemen Semester

| Fitur | Deskripsi |
|-------|-----------|
| **Tambah Semester** | Input tahun akademik (format: YYYY/YYYY) dan semester (GANJIL/GENAP) |
| **Set Aktif** | Mengaktifkan satu semester (otomatis menonaktifkan yang lain) |
| **Hapus Semester** | Hanya bisa hapus semester non-aktif yang tidak memiliki jadwal |

#### 4.6 Panel Admin - Manajemen Pengguna

| Fitur | Deskripsi |
|-------|-----------|
| **Tambah Admin** | Superadmin dapat menambahkan admin/superadmin baru |
| **Edit Admin** | Ubah username, email, role, status aktif |
| **Hapus Admin** | Hanya superadmin, tidak bisa hapus superadmin lain |
| **Reset Lockout** | Reset akun yang terkunci karena gagal login |
| **Kirim Verifikasi** | Kirim email verifikasi ke admin |
| **Proteksi** | Tidak bisa nonaktifkan akun aktif terakhir |

#### 4.7 Panel Admin - Manajemen Settings

| Fitur | Deskripsi |
|-------|-----------|
| **Profil Institusi** | Nama institusi, lokasi, program studi, fakultas |
| **Running Text** | Enable/disable, konten, kecepatan, warna teks & bg |
| **Logo Header** | Pilih tipe logo (kampus/institusi), title 1 & 2 |
| **Keamanan Login** | Max percobaan login, durasi lockout awal |
| **Session Timeout** | Durasi timeout (menit), auto logout on/off |
| **Reset Data** | Hapus semua jadwal & log aktivitas (superadmin only) |
| **Clear Logs** | Hapus semua log aktivitas (superadmin only) |
| **Clear Cache** | Hapus cache aplikasi, route, view, config (superadmin only) |
| **Backup Database** | Backup via mysqldump atau PHP fallback (superadmin only) |

#### 4.8 Panel Admin - Riwayat Backup

| Fitur | Deskripsi |
|-------|-----------|
| **Daftar Backup** | List file backup dengan info ukuran & tanggal |
| **Download Backup** | Unduh file .sql backup |
| **Hapus Backup** | Hapus file backup |

#### 4.9 Panel Admin - Mode Maintenance

| Fitur | Deskripsi |
|-------|-----------|
| **Toggle Maintenance** | Aktifkan/nonaktifkan mode maintenance |
| **Update Pesan** | Ubah pesan yang ditampilkan saat maintenance |
| **Log Maintenance** | Riwayat aktivasi maintenance |

#### 4.10 Panel Admin - Profile & Password

| Fitur | Deskripsi |
|-------|-----------|
| **Update Profile** | Ubah username, no telepon, foto profil |
| **Update Email** | Ubah email (memerlukan password saat ini) |
| **Update Password** | Ubah password (memerlukan password saat ini) |
| **Halaman Khusus Superadmin** | Halaman change password khusus superadmin |

#### 4.11 Panel Admin - Kritik & Saran

| Fitur | Deskripsi |
|-------|-----------|
| **Daftar Saran** | Paginated list dengan filter status & search |
| **Status** | pending → read → responded |
| **Mark Read** | Tandai sebagai dibaca (AJAX) |
| **Update Status & Response** | Ubah status dan beri tanggapan |
| **Hapus Saran** | Superadmin dapat hapus satu atau semua saran |
| **Statistik** | Total, pending, read, responded |

#### 4.12 Autentikasi

| Fitur | Deskripsi |
|-------|-----------|
| **Login** | Dengan proteksi brute force (lockout escalation) |
| **Logout** | Logout manual + auto logout via session timeout |
| **Forgot Password** | Kirim link reset password via email |
| **Reset Password** | Reset password dengan token |
| **Register Superadmin** | Pendaftaran superadmin pertama |
| **Email Verifikasi** | Superadmin harus verifikasi email sebelum aksi tertentu |

#### 4.13 Ekspor Laporan

| Fitur | Deskripsi |
|-------|-----------|
| **Ekspor PDF** | Generate PDF jadwal (landscape, A4) |
| **Ekspor CSV** | Generate CSV kompatibel dengan Excel (UTF-8 BOM) |
| **Filter** | Filter berdasarkan program studi dan semester |

---

### 5. Arsitektur Sistem

#### 5.1 Arsitektur Aplikasi

```
┌─────────────────────────────────────────────────────┐
│                    Client (Browser)                  │
├─────────────────────────────────────────────────────┤
│       Landing Page (Publik)     │   Admin Panel     │
│   HTML + Tailwind CSS + JS      │   (Authenticated) │
├─────────────────────────────────────────────────────┤
│              Laravel 13 Application                  │
├─────────────────────────────────────────────────────┤
│   Controllers        │   Middleware                  │
│   ┌──────────────┐   │   ┌──────────────────────┐   │
│   │ LandingPage  │   │   │ CheckSessionTimeout  │   │
│   │ Auth         │   │   └──────────────────────┘   │
│   │ Admin:       │   │                              │
│   │  - Dashboard │   │   Views (Blade)              │
│   │  - Schedule  │   │   ┌──────────────────────┐   │
│   │  - Room      │   │   │ landing/             │   │
│   │  - Semester  │   │   │ admin/               │   │
│   │  - User      │   │   │ auth/                │   │
│   │  - Settings  │   │   │ components/          │   │
│   │  - Suggestion│   │   │ emails/              │   │
│   │  - Report    │   │   └──────────────────────┘   │
│   └──────────────┘   │                              │
├─────────────────────────────────────────────────────┤
│              Laravel Services                        │
│  ┌──────────┐ ┌──────────┐ ┌───────────────────┐   │
│  │  Models  │ │ Helpers  │ │  Mail (Verifikasi)│   │
│  │ Schedule │ │ auth_    │ │  Reset Password   │   │
│  │ Room     │ │ helper   │ └───────────────────┘   │
│  │ Semester │ └──────────┘                         │
│  │ Setting  │                                      │
│  └──────────┘                                      │
├─────────────────────────────────────────────────────┤
│              Database (MySQL)                        │
│  schedules, rooms, users, settings,                 │
│  semester_settings, suggestions, activity_logs      │
└─────────────────────────────────────────────────────┘
```

#### 5.2 Struktur Direktori

```
app/
├── Helpers/
│   └── auth_helper.php              # Helper functions
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php           # Base controller
│   │   ├── LandingPageController.php
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── ForgotPasswordController.php
│   │   │   └── VerificationController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── MaintenanceController.php
│   │       ├── ProfileController.php
│   │       ├── ReportExportController.php
│   │       ├── RoomController.php
│   │       ├── ScheduleController.php
│   │       ├── SemesterController.php
│   │       ├── SettingsController.php
│   │       ├── SuggestionController.php
│   │       └── UserController.php
│   └── Middleware/
│       └── CheckSessionTimeout.php
├── Mail/
│   ├── VerificationEmail.php
│   └── ResetPasswordEmail.php
├── Models/
│   ├── Room.php
│   ├── Schedule.php
│   ├── SemesterSetting.php
│   └── Setting.php
├── Providers/
│   └── AppServiceProvider.php
├── Mail/
│   └── (Mailables)
bootstrap/
└── app.php                          # Middleware registration
config/
├── app.php
├── filesystems.php
├── mail.php
└── ... (Laravel default configs)
database/
├── migrations/
│   ├── 2024_01_01_000001_create_initial_tables.php
│   ├── 2024_01_01_000002_create_schedules_table.php
│   ├── 2026_07_10_101028_add_session_timeout_settings.php
│   ├── 2026_07_13_102630_create_cache_table.php
│   ├── 2026_07_15_065104_add_foto_to_schedules_table.php
│   ├── 2026_07_19_032211_add_read_by_to_suggestions_table.php
│   ├── 2026_07_19_103308_add_phone_to_users_table.php
│   └── 2026_07_19_104030_add_foto_to_users_table.php
├── seeders/
│   ├── DatabaseSeeder.php
│   ├── RoomSeeder.php
│   ├── ScheduleSeeder.php
│   └── SemesterSettingSeeder.php
resources/
├── views/
│   ├── landing/index.blade.php
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── manage-schedule.blade.php
│   │   ├── manage-rooms.blade.php
│   │   ├── manage-semester.blade.php
│   │   ├── manage-users.blade.php
│   │   ├── manage-settings.blade.php
│   │   ├── maintenance.blade.php
│   │   ├── backup-history.blade.php
│   │   ├── schedule-modals.blade.php
│   │   ├── suggestions.blade.php
│   │   ├── profile.blade.php
│   │   ├── change-password.blade.php
│   │   └── exports/report-pdf.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   ├── forgot-password.blade.php
│   │   ├── reset-password.blade.php
│   │   └── register-superadmin.blade.php
│   ├── components/admin/sidebar.blade.php
│   └── emails/
│       ├── verification.blade.php
│       └── reset-password.blade.php
routes/
└── web.php                         # Semua route definitions
```

---

### 6. Struktur Basis Data

#### 6.1 Tabel `schedules`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| kelas | string | Nama kelas (misal: A1, A2, B1) |
| hari | string | SENIN, SELASA, RABU, KAMIS, JUMAT |
| jam_ke | integer | 1-10 |
| waktu | string | Range waktu "HH:MM - HH:MM" |
| mata_kuliah | string | Nama mata kuliah |
| dosen | string | Nama dosen |
| ruang | string | Nama ruangan |
| foto | string (nullable) | Path foto tambahan |
| semester | string | GANJIL / GENAP |
| tahun_akademik | string | Format "YYYY/YYYY" |
| created_at | timestamp | |
| updated_at | timestamp | |
| **Index** | | (kelas, hari, jam_ke) |

#### 6.2 Tabel `rooms`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| nama_ruang | string | Nama ruangan |
| kapasitas | integer | Kapasitas maksimal |
| fasilitas | text | Daftar fasilitas |
| foto_path | string (nullable) | Path foto ruangan |
| deskripsi | text | Deskripsi ruangan |
| created_at | timestamp | |
| updated_at | timestamp | |

#### 6.3 Tabel `users`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| username | string (unique) | Username login |
| password | string | Hash bcrypt |
| email | string (unique) | Email |
| role | string | 'admin' atau 'superadmin' |
| is_active | boolean | Status aktif akun |
| foto | string (nullable) | Path foto profil |
| phone | string (nullable) | Nomor telepon |
| failed_attempts | integer | Counter gagal login |
| locked_until | timestamp (nullable) | Waktu lockout berakhir |
| lockout_multiplier | integer | Level multiplier lockout |
| last_failed_attempt | timestamp (nullable) | Waktu gagal login terakhir |
| email_verified_at | timestamp (nullable) | Waktu verifikasi email |
| email_verified_token | string (nullable) | Token verifikasi email |
| last_login | timestamp (nullable) | Waktu login terakhir |
| created_at | timestamp | |
| updated_at | timestamp | |

#### 6.4 Tabel `settings`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| setting_key | string (unique) | Key pengaturan |
| setting_value | text | Value pengaturan |
| created_at | timestamp | |
| updated_at | timestamp | |

**Daftar Setting Keys:**

| Key | Default | Deskripsi |
|-----|---------|-----------|
| tahun_akademik | - | Tahun akademik (deprecated, pakai semester_settings) |
| institusi_nama | Politeknik Negeri Padang | Nama institusi |
| institusi_lokasi | PSDKU Tanah Datar | Lokasi institusi |
| program_studi | D3 Sistem Informasi | Program studi |
| fakultas | Fakultas Teknik | Fakultas |
| admin_email | - | Email admin |
| running_text_enabled | 0 | Aktifkan running text |
| running_text_content | - | Konten running text |
| running_text_speed | normal | Kecepatan running text |
| running_text_color | #ffffff | Warna teks running text |
| running_text_bg_color | #4361ee | Warna background running text |
| max_login_attempts | 5 | Maksimal percobaan login |
| lockout_initial_duration | 15 | Durasi lockout awal (menit) |
| lockout_max_multiplier | 10 | Multiplier maksimal lockout |
| session_timeout_minutes | 30 | Durasi session timeout |
| session_auto_logout_enabled | 1 | Aktifkan auto logout |
| header_logo_type | kampus | Tipe logo header |
| header_title_1 | - | Judul header 1 |
| header_title_2 | - | Judul header 2 |
| maintenance_mode | 0 | Mode maintenance on/off |
| maintenance_message | - | Pesan maintenance |

#### 6.5 Tabel `semester_settings`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| tahun_akademik | string | Format "YYYY/YYYY" |
| semester | string | 'GANJIL' / 'GENAP' |
| is_active | boolean | Status semester aktif |
| created_at | timestamp | |
| updated_at | timestamp | |

#### 6.6 Tabel `suggestions`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| name | string | Nama pengirim |
| email | string (nullable) | Email pengirim |
| message | text | Isi pesan |
| status | string | 'pending', 'read', 'responded' |
| response | text (nullable) | Tanggapan admin |
| responded_by | bigint (nullable, FK users) | Admin yang merespon |
| responded_at | timestamp (nullable) | Waktu respon |
| read_by | bigint (nullable, FK users) | Admin yang membaca |
| read_at | timestamp (nullable) | Waktu dibaca |
| ip_address | string | IP pengirim |
| user_agent | string | User agent pengirim |
| created_at | timestamp | |
| updated_at | timestamp | |

#### 6.7 Tabel `activity_logs`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigint (PK) | Auto increment |
| user_id | bigint (nullable, FK users) | ID user |
| action | string | Aksi yang dilakukan |
| description | text | Deskripsi aktivitas |
| ip_address | string | IP address |
| user_agent | string | User agent |
| created_at | timestamp | |

---

### 7. Teknologi yang Digunakan

| Teknologi | Versi | Kegunaan |
|-----------|-------|----------|
| **PHP** | ^8.3 | Bahasa pemrograman backend |
| **Laravel** | ^13.8 | Framework PHP |
| **MySQL** | - | Database management system |
| **Tailwind CSS** | ^4.0 | Utility-first CSS framework |
| **Vite** | ^8.0 | Build tool untuk frontend |
| **DOMPDF (barryvdh/laravel-dompdf)** | ^3.1 | Generate PDF |
| **Laravel Tinker** | ^3.0 | REPL untuk debugging |
| **Concurrently** | ^9.0.1 | Menjalankan multiple dev commands |
| **Session** | File/Database | Session driver |

---

### 8. Roles & Permission

#### 8.1 Superadmin

- Akses penuh ke semua fitur admin
- Menambah/mengedit/menghapus admin
- Mengubah role admin menjadi superadmin
- Reset data (hapus semua jadwal & log)
- Backup database
- Clear cache
- Hapus semua saran
- Mengubah password lewat halaman khusus
- **Wajib verifikasi email** sebelum melakukan aksi tulis (POST, PUT, DELETE, PATCH)

#### 8.2 Admin

- Akses dashboard, jadwal, ruangan, semester, saran
- Edit profil sendiri (username, foto, phone)
- Mengganti password sendiri
- **Tidak bisa** mengelola pengguna
- **Tidak bisa** mengakses menu settings sensitif (reset data, backup, clear cache)
- **Tidak bisa** mengedit/menghapus superadmin
- **Tidak wajib** verifikasi email untuk login

---

### 9. Alur Sistem

#### 9.1 Alur Landing Page

```
User mengakses /
                │
                ▼
    Cek mode maintenance?
    ├── Ya ──► Tampilkan halaman maintenance
    │
    └── Tidak
                │
                ▼
    Ambil semester aktif & setting institusi
                │
                ▼
    Tentukan hari & kelas default
    (hari berdasarkan hari ini, kelas dari list)
                │
                ▼
    Query jadwal sesuai filter
    (hari, kelas, semester aktif)
                │
                ▼
    Hitung jadwal berlangsung & berikutnya
    (termasuk jadwal di hari berikutnya)
                │
                ▼
    Render view dengan data lengkap
```

#### 9.2 Alur Login & Proteksi Brute Force

```
User submit login
        │
        ▼
    Cari username di database
    ├── Tidak ditemukan ──► "Username tidak ditemukan"
    │
    └── Ditemukan
            │
            ▼
    Cek status aktif
    ├── Tidak aktif ──► "Akun telah dinonaktifkan"
    │
    └── Aktif
            │
            ▼
    Cek lockout
    ├── Terkunci ──► "Akun terkunci, coba lagi dalam X"
    │
    └── Tidak terkunci
            │
            ▼
    Verifikasi password
    ├── Salah ──► Increment failed_attempts
    │             ├── failed_attempts >= max ──► Lockout (multiplier progression)
    │             └── failed_attempts < max ──► "Password salah, sisa X percobaan"
    │
    └── Benar
            │
            ▼
    Reset failed_attempts, update last_login
    Set session (user_id, username, role, user_foto)
    Redirect ke dashboard
```

#### 9.3 Progresi Lockout

Lockout menggunakan *exponential backoff* dengan multiplier:

| Lockout ke- | Durasi (menit) | Total Detik |
|-------------|----------------|-------------|
| 1 | 15 | 900 |
| 2 | 30 | 1.800 |
| 3 | 60 | 3.600 |
| 4 | 120 | 7.200 |
| 5 | 240 | 14.400 |
| ... | ... (×2) | ... |
| Maks | 15 × 2^(10-1) = 7.680 menit (~5,3 hari) | ... |

Rumus: `durasi_detik = initial_duration × 60 × 2^(multiplier - 1)`

---

### 10. Keamanan

| Aspek | Implementasi |
|-------|-------------|
| **Autentikasi** | Session-based, password hashing (bcrypt) |
| **Brute Force Protection** | Progressive lockout dengan exponential backoff |
| **Session Timeout** | Auto logout setelah periode idle (configurable via settings) |
| **Email Verification** | Superadmin wajib verifikasi email untuk aksi tulis |
| **Role-based Access** | Middleware di controller (pengecekan role via session) |
| **Input Validation** | Server-side validation di setiap controller |
| **XSS Protection** | htmlspecialchars, Blade auto-escaping |
| **CSRF** | Laravel CSRF token untuk semua POST requests |
| **File Upload** | Validasi tipe file, ukuran maksimal 2MB |
| **Backup Security** | Validasi filename pattern sebelum download/delete |
| **Last Active Account** | Proteksi nonaktifkan/hapus akun aktif terakhir |
| **Lockout Cancel** | Hanya superadmin yang bisa cancel lockout |

---

### 11. Non-Fungsional Requirements

| Kategori | Requirement |
|----------|-------------|
| **Kinerja** | Landing page harus load < 3 detik untuk 500+ jadwal |
| **Ketersediaan** | Sistem harus tersedia 24/7 (kecuali maintenance) |
| **Kompatibilitas** | Mendukung browser modern (Chrome, Firefox, Edge, Safari) |
| **Responsivitas** | Landing page responsif untuk mobile & desktop |
| **Keamanan** | Semua data sensitif di-hash, session aman |
| **Maintainability** | Kode terstruktur dengan Laravel best practices |
| **Backup** | Database dapat di-backup kapan saja oleh superadmin |
| **Data Retention** | Saran & activity logs dapat dihapus oleh superadmin |

---

### 12. Milestone & Pengembangan

| Fase | Fitur | Status |
|------|-------|--------|
| **MVP** | Landing page jadwal, CRUD jadwal, autentikasi | ✅ **Selesai** |
| **V1.0** | Manajemen ruangan, semester, settings, suggestions | ✅ **Selesai** |
| **V1.1** | Maintenance mode, backup database, report export | ✅ **Selesai** |
| **V1.2** | Running text, foto ruangan, email verification | ✅ **Selesai** |
| **V1.3** | Session timeout, brute force protection, foto jadwal | ✅ **Selesai** |
| **V1.4** | Bulk insert jadwal, lockout multiplier progression | ✅ **Selesai** |

---

## Panduan Instalasi

### Prasyarat

- PHP ^8.3
- Composer
- MySQL
- Node.js & npm

### Langkah Instalasi

```bash
# Clone repository
git clone https://github.com/muhammadsyaiful2601/jadwal-laravel.git
cd jadwal-laravel

# Install dependencies PHP
composer install

# Copy environment & generate key
copy .env.example .env
php artisan key:generate

# Konfigurasi database di .env
# DB_DATABASE=jadwal_kampus
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migrasi & seeder
php artisan migrate
php artisan db:seed

# Install dependencies frontend
npm install

# Build assets
npm run build

# Jalankan server development
php artisan serve
```

### Menjalankan Development

```bash
# Menjalankan semua service (server, queue, logs, vite)
composer dev

# Atau manual:
php artisan serve          # Server Laravel
npm run dev               # Vite development
```

---

## Lingkungan Pengembangan

- **IDE**: Visual Studio Code
- **OS**: Windows 11
- **Web Server**: Laravel Artisan Serve / XAMPP
- **Database**: MySQL via XAMPP/Laragon
- **Version Control**: Git (GitHub)
- **Remote Origin**: `https://github.com/muhammadsyaiful2601/jadwal-laravel.git`
- **Latest Commit**: `1679a1a4ce8b1be8d6559609104359c91b82dc01`

---

### Contributors

- **Muhammad Syaiful** - Developer

---

### Lisensi

Proyek ini dibuat untuk kebutuhan akademik dan pengelolaan jadwal perkuliahan. Lisensi: MIT (sesuai Laravel framework).