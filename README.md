# SPAL - Sistem Peminjaman Alat Laboratorium

## 📋 Deskripsi

SPAL adalah sistem manajemen peminjaman alat laboratorium berbasis web untuk **SMKN 2 Palembang**. Sistem ini dibangun menggunakan **Laravel 13**, **PHP 8.3+**, **MySQL**, **Tailwind CSS**, dan **Vite**.

Sistem memfasilitasi:
- ✅ Registrasi dan autentikasi pengguna
- ✅ Katalog alat laboratorium dengan pencarian dan filter
- ✅ Pengajuan peminjaman alat
- ✅ Approval workflow untuk laboran
- ✅ QR Code generation dan scanning
- ✅ Monitoring kondisi alat
- ✅ Notifikasi otomatis
- ✅ Laporan statistik dengan export PDF/Excel
- ✅ Sistem blacklist untuk peminjam bermasalah

## 🚀 Stack Teknologi

- **Backend:** Laravel 13, PHP 8.3+
- **Database:** MySQL/SQLite
- **Frontend:** Blade, Tailwind CSS, Vite
- **Libraries:**
  - Laravel Breeze (Authentication)
  - Maatwebsite Excel (Export)
  - DOMPDF (PDF Generation)
  - Endroid QR Code (QR Code)
  - Chart.js (Charts)
  - CountUp.js (Animations)
  - SweetAlert2 (Notifications)

## 📦 Instalasi

### Prerequisites
- PHP 8.3 atau lebih tinggi
- MySQL/MariaDB
- Node.js 16+
- Composer

### Setup Langkah demi Langkah

1. **Clone Repository**
```bash
cd C:\Users\oyuu5\OneDrive\Dokumen\GitHub\RPL-Projek-SPAL-
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure Database** 
Edit `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

5. **Run Migrations & Seed**
```bash
php artisan migrate
php artisan db:seed
```

6. **Build Assets**
```bash
npm run build
```

7. **Start Development Servers**
```bash
npm run dev    # Terminal 1 - Vite
php artisan serve  # Terminal 2 - Laravel
```

Server akan berjalan pada:
- Frontend: http://localhost:5173
- Backend: http://localhost:8000

## 👥 Demo Credentials

### Admin
- Email: `admin@spal.com`
- Password: `password`
- Role: Admin

### Laboran
- Email: `laboran@spal.com`
- Password: `password`
- Role: Laboran

### Students (10 users)
- Email: Tergenerate otomatis
- Password: `password`
- Role: User

## 📂 Struktur Folder

```
app/
├── Http/
│   ├── Controllers/      # Controllers untuk logika bisnis
│   ├── Middleware/       # Role-based access control
│   └── Requests/         # Form validation
├── Models/               # Database models
├── Repositories/         # Data access layer
├── Services/             # Business logic layer
├── Exports/              # Excel exports
├── Policies/             # Authorization policies
└── Notifications/        # Notification classes

resources/
├── views/
│   ├── auth/            # Login & Register
│   ├── dashboard/       # Admin & User dashboards
│   ├── alat/           # Equipment catalog
│   ├── peminjaman/     # Borrowing
│   ├── approval/       # Laboran approval
│   ├── report/         # Reports
│   ├── profile/        # User profile
│   └── layouts/        # Base layouts
├── css/
│   └── app.css         # Tailwind CSS
└── js/
    └── app.js          # JavaScript

database/
├── migrations/         # Database schema
└── seeders/           # Database seeders

routes/
├── web.php            # Web routes
└── auth.php           # Authentication routes
```

## 🎨 Fitur Utama

### 1. Dashboard
- **Admin Dashboard:** Statistik total alat, alat tersedia, alat dipinjam, user total, grafik bulanan
- **User Dashboard:** Pengajuan aktif, riwayat peminjaman, alat populer

### 2. Katalog Alat
- Search by nama/kode
- Filter by kategori dan status
- Pagination
- Detail view dengan informasi lengkap

### 3. Peminjaman
- Formulir pengajuan dengan tanggal rencana kembali
- Upload foto kondisi awal dan akhir
- Status tracking (Pending → Approved → Returned)

### 4. Approval Workflow (Laboran)
- Daftar pengajuan pending
- Approve atau reject dengan alasan
- Proses pengembalian alat
- Automatic blacklist jika telat > 3 kali

### 5. QR Code
- Generate QR code untuk setiap alat
- Scan in/out untuk tracking

### 6. Laporan
- Generate report harian, mingguan, bulanan, tahunan
- Export ke PDF
- Export ke Excel (.xlsx)

### 7. Blacklist System
- Auto-blacklist jika:
  - Telat kembali > 3 kali
  - Merusak alat
- Manual blacklist oleh admin

## 🔐 Role & Permission

### Admin
- ✅ Dashboard dengan statistik lengkap
- ✅ Kelola alat (CRUD)
- ✅ Kelola user
- ✅ Approval peminjaman
- ✅ Scan QR
- ✅ Blacklist management
- ✅ Generate laporan

### Laboran
- ✅ Dashboard (read-only)
- ✅ Kelola alat (CRUD)
- ✅ Approval peminjaman
- ✅ Proses pengembalian
- ✅ Scan QR
- ✅ Generate laporan

### User/Siswa
- ✅ Lihat dashboard pribadi
- ✅ Browse katalog alat
- ✅ Ajukan peminjaman
- ✅ Lihat status pengajuan
- ✅ Upload foto kondisi
- ✅ Lihat riwayat peminjaman

## 🎨 Design System

### Color Palette
- **Primary:** #1E3A8A (Blue)
- **Secondary:** #4F46E5 (Indigo)
- **Success:** #10B981 (Green)
- **Warning:** #F59E0B (Amber)
- **Danger:** #EF4444 (Red)
- **Background:** #F8FAFC (Light Gray)
- **Text:** #1E293B (Dark Slate)

### Animations
- Smooth hover transitions (scale: 1.05)
- Active states (scale: 0.95)
- Fade in animations
- Slide animations
- CountUp number animations
- Card hover shadows

## 📄 License

MIT License - Copyright (c) 2024 SMKN 2 Palembang

---

**Versi:** 1.0.0
**Last Updated:** 2024

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
