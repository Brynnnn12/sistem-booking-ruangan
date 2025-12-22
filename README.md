# 🏢 Meeting Room Booking System

> Sistem manajemen pemesanan ruang meeting berbasis web dengan fitur real-time conflict detection, role-based access control, dan approval workflow.

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.0+-06B6D4?style=flat&logo=tailwind-css)](https://tailwindcss.com)

---

## 📋 Deskripsi Proyek

Sistem booking ruang meeting internal untuk kantor/organisasi yang menangani pemesanan ruang rapat dengan **real-time conflict checking**, **approval workflow**, dan **manajemen berbasis role**. Sistem ini dirancang sebagai solusi digital yang realistis dan dapat diterapkan di startup, kantor, atau organisasi modern.

### 🎯 Problem Statement

-   **Konflik jadwal** - Beberapa tim memesan ruang yang sama pada waktu bersamaan
-   **Tidak ada tracking** - Kesulitan melacak siapa menggunakan ruang kapan
-   **Manual coordination** - Koordinasi via chat/email yang tidak efisien dan rentan error
-   **Tidak ada audit trail** - Tidak ada catatan lengkap untuk compliance dan reporting

### 💡 Solusi

Aplikasi web yang menyediakan:

-   ✅ **Real-time availability checking** - Cek ketersediaan ruang secara langsung
-   ✅ **Conflict detection** - Sistem otomatis mencegah double booking
-   ✅ **Approval workflow** - Admin dapat menyetujui/menolak booking
-   ✅ **Role-based access** - Pembatasan akses berdasarkan role (Admin/Staff)
-   ✅ **Complete audit trail** - History lengkap untuk setiap booking
-   ✅ **Responsive design** - Dapat diakses dari desktop dan mobile

### 👥 Target Users

1. **Admin** - Mengelola master data ruang, menyetujui booking, dan monitoring
2. **Staff** - Membuat booking untuk kebutuhan meeting tim

---

## ✨ Fitur Utama

### 🔐 Authentication & Authorization

-   **Laravel Breeze** - Sistem autentikasi bawaan dengan email verification
-   **Role-based Access Control** - Menggunakan Spatie Laravel Permission
    -   **Admin**: Full access (CRUD rooms, approve/reject bookings, manage all data)
    -   **Staff**: Create & manage own bookings, view available rooms
-   **Email Verification** - User harus verifikasi email sebelum akses dashboard

### 🏢 Room Management

-   **CRUD Operations** (Admin only)
    -   Create, Read, Update, Delete ruangan
    -   Informasi: Nama, Lokasi, Kapasitas
    -   Status aktif/non-aktif untuk maintenance
-   **Room Listing** (All authenticated users)
    -   Filter berdasarkan kapasitas
    -   Search by nama/lokasi
    -   Display availability status

### 📅 Booking Management

#### **Untuk Staff:**

-   ✅ **Create Booking**
    -   Pilih ruang dan waktu
    -   Real-time availability checking
    -   Automatic conflict detection
    -   Catatan/notes untuk keperluan meeting
-   ✅ **View Bookings**
    -   Lihat semua booking milik sendiri
    -   Filter by status (Pending, Approved, Rejected, Cancelled)
    -   Detail informasi booking
-   ✅ **Edit/Cancel Booking**
    -   Update booking pending (belum diapprove)
    -   Cancel booking pending
    -   Tidak bisa ubah/cancel booking yang sudah approved

#### **Untuk Admin:**

-   ✅ **View All Bookings**
    -   Monitoring semua booking dari semua user
    -   Filter by room, user, status, date range
-   ✅ **Approval Workflow**
    -   Approve/Reject booking pending
    -   Recorded approval history (approved_by)
-   ✅ **Cancel Any Booking**
    -   Cancel booking apapun (force cancel untuk emergency)

### 🔍 Conflict Detection

-   **Real-time validation** - Check overlap saat create/update booking
-   **Algorithm cerdas** - Deteksi bentrok dengan pertimbangan:
    -   Same room
    -   Overlapping time range
    -   Only approved bookings counted
-   **User-friendly error** - Pesan error jelas dengan info waktu bentrok

### 📊 Dashboard & Reporting

-   **Role-based Dashboard**
    -   Admin: Overview stats, recent bookings, charts
    -   Staff: Upcoming meetings, quick booking access
-   **Charts & Analytics** (Chart.js)
    -   Booking trends
    -   Room utilization
    -   Popular time slots

### 🎨 UI/UX Features

-   **Responsive Design** - Tailwind CSS, mobile-friendly
-   **Interactive UI** - Alpine.js untuk interaktivitas
-   **Sweet Alerts** - Notifikasi cantik untuk success/error messages
-   **Loading States** - Feedback visual saat proses async
-   **Form Validation** - Real-time validation dengan error messages

---

## 🛠️ Tech Stack

---

## 🛠️ Tech Stack

### Backend

| Technology            | Version | Purpose                      |
| --------------------- | ------- | ---------------------------- |
| **Laravel**           | 12.x    | PHP Framework                |
| **PHP**               | 8.2+    | Programming Language         |
| **MySQL**             | 8.0+    | Database                     |
| **Laravel Breeze**    | 2.3+    | Authentication Scaffolding   |
| **Spatie Permission** | 6.24+   | Role & Permission Management |

### Frontend

| Technology       | Version | Purpose                          |
| ---------------- | ------- | -------------------------------- |
| **Tailwind CSS** | 3.1+    | Utility-first CSS Framework      |
| **Alpine.js**    | 3.4+    | Lightweight JavaScript Framework |
| **Chart.js**     | 4.5+    | Data Visualization & Charts      |
| **SweetAlert2**  | 11.26+  | Beautiful Alert/Modal Dialogs    |
| **Vite**         | 7.0+    | Frontend Build Tool              |

### Testing

| Technology   | Version | Purpose           |
| ------------ | ------- | ----------------- |
| **Pest PHP** | 4.2+    | Testing Framework |
| **PHPUnit**  | 11.x    | Unit Testing      |

### Development Tools

-   **Composer** - PHP Dependency Manager
-   **NPM** - JavaScript Package Manager
-   **Laravel Pint** - PHP Code Style Fixer
-   **Laravel Sail** - Docker Development Environment (Optional)

---

## 🗄️ Database Schema

### Table: users

```sql
id                  BIGINT (PK, Auto Increment)
name                VARCHAR(255)
email               VARCHAR(255) UNIQUE
email_verified_at   TIMESTAMP NULLABLE
password            VARCHAR(255)
remember_token      VARCHAR(100) NULLABLE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

### Table: roles (Spatie Permission)

```sql
id          BIGINT (PK)
name        VARCHAR(255)  -- 'Admin', 'Staff'
guard_name  VARCHAR(255)  -- 'web'
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

### Table: rooms

```sql
id          BIGINT (PK, Auto Increment)
name        VARCHAR(255)              -- Nama ruangan
location    VARCHAR(255)              -- Lokasi/lantai
capacity    INTEGER                   -- Kapasitas orang
is_active   BOOLEAN DEFAULT TRUE      -- Status aktif
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

### Table: bookings

```sql
id           BIGINT (PK, Auto Increment)
room_id      BIGINT (FK → rooms.id) ON DELETE CASCADE
user_id      BIGINT (FK → users.id) ON DELETE CASCADE
approved_by  BIGINT NULLABLE (FK → users.id) ON DELETE SET NULL
start_time   DATETIME                 -- Waktu mulai booking
end_time     DATETIME                 -- Waktu selesai booking
status       ENUM('pending', 'approved', 'rejected', 'cancelled') DEFAULT 'pending'
note         TEXT NULLABLE            -- Catatan/keperluan meeting
created_at   TIMESTAMP
updated_at   TIMESTAMP

-- Indexes untuk optimasi query conflict checking
INDEX idx_room_time (room_id, start_time, end_time)
```

### Relasi Database

```
users (1) ──── (N) bookings
rooms (1) ──── (N) bookings
users (1) ──── (N) bookings [approved_by]
users (N) ─┬─ (N) roles [via model_has_roles]
           └─ (N) permissions [via model_has_permissions]
```

---

## 📐 Arsitektur Aplikasi

### Design Pattern: Repository-Service Pattern

```
Controller → Service → Repository → Model → Database
```

**Keuntungan:**

-   ✅ Separation of Concerns
-   ✅ Testability (Easy to mock)
-   ✅ Reusability
-   ✅ Maintainability

### Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── BookingController.php    # Handle HTTP requests booking
│   │   ├── RoomController.php       # Handle HTTP requests room
│   │   └── ProfileController.php
│   └── Requests/
│       ├── Booking/
│       │   ├── StoreBookingRequest.php
│       │   └── UpdateBookingRequest.php
│       └── Room/
│           ├── StoreRoomRequest.php
│           └── UpdateRoomRequest.php
├── Models/
│   ├── User.php
│   ├── Room.php
│   └── Booking.php
├── Policies/
│   ├── BookingPolicy.php            # Authorization rules booking
│   └── RoomPolicy.php               # Authorization rules room
├── Repositories/
│   ├── BookingRepository.php        # Data access layer booking
│   └── RoomRepository.php           # Data access layer room
└── Services/
    ├── BookingService.php           # Business logic booking
    └── RoomService.php              # Business logic room

resources/
├── views/
│   ├── dashboard/
│   │   ├── booking/
│   │   │   ├── index.blade.php      # List bookings
│   │   │   ├── create.blade.php     # Form create booking
│   │   │   ├── edit.blade.php       # Form edit booking
│   │   │   └── show.blade.php       # Detail booking
│   │   └── room/
│   │       ├── index.blade.php      # List rooms
│   │       ├── create.blade.php     # Form create room
│   │       ├── edit.blade.php       # Form edit room
│   │       └── show.blade.php       # Detail room
│   ├── components/
│   │   └── dashboard/
│   │       ├── sidebar.blade.php    # Sidebar navigation
│   │       └── mobile-sidebar.blade.php
│   └── layouts/
│       ├── app.blade.php            # Main layout
│       └── guest.blade.php          # Guest layout
├── js/
│   ├── app.js                       # Main JS entry point
│   └── bootstrap.js                 # Axios, Echo config
└── css/
    └── app.css                      # Tailwind CSS

tests/
├── Feature/
│   ├── Bookings/
│   │   └── BookingTest.php          # 12 test cases
│   └── Rooms/
│       └── RoomTest.php             # 9 test cases
└── Unit/
```

---

## 🔒 Business Rules & Validation

### Booking Rules

| Rule                    | Implementation                        | Validation               |
| ----------------------- | ------------------------------------- | ------------------------ |
| **No Overlapping**      | Query check approved bookings         | `hasOverlap()` method    |
| **Status Flow**         | pending → approved/rejected/cancelled | Enum validation          |
| **Edit Permission**     | Only pending bookings can be edited   | Policy check             |
| **Cancel Permission**   | Staff: own pending, Admin: all        | BookingPolicy            |
| **Approval Permission** | Admin only, pending only              | `approve()` & `reject()` |

### Room Rules

| Rule          | Validation                   |
| ------------- | ---------------------------- |
| **Name**      | Required, max 255 characters |
| **Location**  | Required, max 255 characters |
| **Capacity**  | Required, minimum 1 person   |
| **is_active** | Boolean, default true        |

### Conflict Detection Algorithm

```php
// Cek overlap dengan kondisi:
// 1. Same room_id
// 2. Status = 'approved'
// 3. Time range overlaps:
//    - New start antara existing start-end
//    - New end antara existing start-end
//    - New booking encompass existing booking

WHERE room_id = ?
  AND status = 'approved'
  AND (
    (start_time BETWEEN ? AND ?)
    OR (end_time BETWEEN ? AND ?)
    OR (start_time <= ? AND end_time >= ?)
  )
```

---

## 🚀 Installation & Setup

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   MySQL/MariaDB
-   Git

### Step-by-Step Installation

#### 1. Clone Repository

```bash
git clone https://github.com/Brynnnn12/sistem-booking-ruangan.git
cd sistem-booking-ruangan
```

#### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

#### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Configure Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=booking_ruangan
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### 5. Run Migrations & Seeders

```bash
# Run migrations
php artisan migrate

# Seed roles and sample data
php artisan db:seed
```

**Default Users:**

-   **Admin**: admin@example.com / password
-   **Staff**: staff@example.com / password

#### 6. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

#### 7. Run Application

```bash
# Using PHP built-in server
php artisan serve

# Using Laravel Herd (Recommended)
# Access: http://sistem-booking-ruangan.test
```

#### 8. Run Tests (Optional)

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --filter=BookingTest

# With coverage (requires Xdebug)
php artisan test --coverage
```

---

## 🧪 Testing

### Test Coverage

#### Booking Tests (12 test cases) ✅

```bash
✓ Staff bisa melihat booking miliknya
✓ Admin bisa melihat semua booking
✓ User tanpa role tidak bisa akses booking
✓ Staff bisa membuat booking
✓ User tanpa role tidak bisa membuat booking
✓ Staff bisa update booking pending miliknya
✓ Staff tidak bisa update booking approved
✓ Staff bisa hapus booking pending miliknya
✓ Admin bisa approve booking pending
✓ Admin bisa reject booking pending
✓ Staff bisa cancel booking pending miliknya
✓ Staff tidak bisa cancel booking approved
```

#### Room Tests (9 test cases) ✅

```bash
✓ Guest tidak bisa akses rooms
✓ User belum verifikasi email diarahkan ke verifikasi
✓ Admin bisa melihat daftar ruangan
✓ Admin bisa create room
✓ Admin bisa update room
✓ Admin bisa delete room
✓ Staff bisa melihat daftar ruangan
✓ Staff tidak bisa create room
✓ Staff tidak bisa edit/delete room
```

### Running Tests

```bash
# All tests
php artisan test

# Specific test file
php artisan test tests/Feature/Bookings/BookingTest.php

# With output
php artisan test --verbose

# SQLite in-memory untuk testing (configured in .env.testing)
```

---

## 📱 API Endpoints

### Web Routes (Protected by auth + verified middleware)

#### Dashboard

---

## 📱 API Endpoints

### Web Routes (Protected by auth + verified middleware)

#### Dashboard

| Method | URI          | Name            | Access       |
| ------ | ------------ | --------------- | ------------ |
| GET    | `/dashboard` | dashboard.index | Admin, Staff |

#### Profile Management

| Method | URI                  | Name                      | Access       |
| ------ | -------------------- | ------------------------- | ------------ |
| GET    | `/dashboard/profile` | dashboard.profile.edit    | Admin, Staff |
| PATCH  | `/dashboard/profile` | dashboard.profile.update  | Admin, Staff |
| DELETE | `/dashboard/profile` | dashboard.profile.destroy | Admin, Staff |

#### Room Management

| Method | URI                            | Name                    | Access                     |
| ------ | ------------------------------ | ----------------------- | -------------------------- |
| GET    | `/dashboard/rooms`             | dashboard.rooms.index   | Admin (CRUD), Staff (View) |
| GET    | `/dashboard/rooms/create`      | dashboard.rooms.create  | Admin                      |
| POST   | `/dashboard/rooms`             | dashboard.rooms.store   | Admin                      |
| GET    | `/dashboard/rooms/{room}`      | dashboard.rooms.show    | Admin, Staff               |
| GET    | `/dashboard/rooms/{room}/edit` | dashboard.rooms.edit    | Admin                      |
| PATCH  | `/dashboard/rooms/{room}`      | dashboard.rooms.update  | Admin                      |
| DELETE | `/dashboard/rooms/{room}`      | dashboard.rooms.destroy | Admin                      |

#### Booking Management

| Method | URI                                  | Name                       | Access                    |
| ------ | ------------------------------------ | -------------------------- | ------------------------- |
| GET    | `/dashboard/bookings`                | dashboard.bookings.index   | Admin (All), Staff (Own)  |
| GET    | `/dashboard/bookings/create`         | dashboard.bookings.create  | Admin, Staff              |
| POST   | `/dashboard/bookings`                | dashboard.bookings.store   | Admin, Staff              |
| GET    | `/dashboard/bookings/{booking}`      | dashboard.bookings.show    | Owner, Admin              |
| GET    | `/dashboard/bookings/{booking}/edit` | dashboard.bookings.edit    | Owner (if pending), Admin |
| PATCH  | `/dashboard/bookings/{booking}`      | dashboard.bookings.update  | Owner (if pending), Admin |
| DELETE | `/dashboard/bookings/{booking}`      | dashboard.bookings.destroy | Owner (if pending), Admin |

#### Booking Actions

| Method | URI                                     | Name                       | Access                    |
| ------ | --------------------------------------- | -------------------------- | ------------------------- |
| PATCH  | `/dashboard/bookings/{booking}/approve` | dashboard.bookings.approve | Admin                     |
| PATCH  | `/dashboard/bookings/{booking}/reject`  | dashboard.bookings.reject  | Admin                     |
| PATCH  | `/dashboard/bookings/{booking}/cancel`  | dashboard.bookings.cancel  | Owner (if pending), Admin |

#### API Endpoints (AJAX)

| Method | URI                                                    | Purpose                            |
| ------ | ------------------------------------------------------ | ---------------------------------- |
| GET    | `/dashboard/api/available-rooms?start_time=&end_time=` | Get available rooms for time range |

---

## 🎨 UI/UX Highlights

### Design Philosophy

-   **Clean & Modern** - Minimalist design dengan fokus pada functionality
-   **Responsive First** - Mobile-friendly dari awal
-   **Accessible** - Semantic HTML, keyboard navigation support
-   **Fast Loading** - Optimized assets dengan Vite

### Key UI Components

#### 1. Dashboard

-   **Admin Dashboard**: Stats cards, charts (Chart.js), recent bookings table
-   **Staff Dashboard**: Upcoming meetings, quick booking button, room availability

#### 2. Room Selection (Booking Create)

-   **Time Picker**: Native datetime-local untuk pilih waktu
-   **Real-time Filtering**: Alpine.js untuk filter ruangan available
-   **Interactive Cards**: Click card to open booking modal
-   **Loading States**: Spinner saat fetch available rooms

#### 3. Booking Table

-   **Sortable Columns**: Click header untuk sort
-   **Filter Tabs**: Status-based filtering (Pending, Approved, Rejected, Cancelled)
-   **Action Buttons**: Context-aware buttons (Edit, Cancel, Approve, Reject)
-   **Badge Status**: Color-coded status badges

#### 4. Alerts & Notifications

-   **SweetAlert2**: Beautiful modal dialogs
    -   Success notifications
    -   Confirmation dialogs (delete, cancel)
    -   Error messages dengan detail
-   **Flash Messages**: Laravel session flash dengan auto-dismiss

#### 5. Forms

-   **Real-time Validation**: Inline error messages
-   **Date/Time Picker**: User-friendly input
-   **Auto-focus**: First field auto-focused
-   **Loading States**: Disabled buttons saat submit

### Color Scheme (Tailwind)

-   **Primary**: Blue (600-800) - Actions, links
-   **Success**: Green (600) - Approved status
-   **Warning**: Yellow (600) - Pending status
-   **Danger**: Red (600) - Rejected, Cancelled
-   **Neutral**: Gray (50-900) - Backgrounds, text

---

## 🔐 Security Features

### Authentication & Authorization

-   ✅ **Email Verification** - Wajib verifikasi email sebelum akses
-   ✅ **Password Hashing** - Bcrypt hashing (Laravel default)
-   ✅ **CSRF Protection** - Token validation untuk semua form submissions
-   ✅ **Policy-based Authorization** - Gate & Policy untuk fine-grained access control
-   ✅ **Session Management** - Secure session handling

### Data Protection

-   ✅ **SQL Injection Prevention** - Eloquent ORM & prepared statements
-   ✅ **XSS Protection** - Blade templating auto-escapes output
-   ✅ **Mass Assignment Protection** - `$fillable` di models
-   ✅ **Foreign Key Constraints** - Database-level referential integrity

### Best Practices Implemented

-   ✅ **Environment Variables** - Sensitive data di `.env`
-   ✅ **API Rate Limiting** - Throttling untuk prevent abuse
-   ✅ **Input Validation** - Form Request classes dengan rules
-   ✅ **Error Handling** - Custom error pages, no stack traces di production

---

## 📊 Performance Optimization

### Database

-   ✅ **Indexes** - Composite index untuk conflict checking (`room_id`, `start_time`, `end_time`)
-   ✅ **Eager Loading** - `with()` untuk prevent N+1 queries
-   ✅ **Query Optimization** - Select only needed columns
-   ✅ **Connection Pooling** - MySQL connection reuse

### Frontend

-   ✅ **Vite Build Tool** - Fast HMR, optimized production builds
-   ✅ **Asset Minification** - CSS & JS minified
-   ✅ **Lazy Loading** - Components loaded on-demand
-   ✅ **CDN Ready** - Static assets dapat di-serve via CDN

### Caching (Future Enhancement)

-   ⏳ **Query Caching** - Cache frequently accessed data
-   ⏳ **View Caching** - Blade template compilation cache
-   ⏳ **Redis** - Session & cache driver

---

## 🚢 Deployment Guide

### Production Checklist

#### Pre-deployment

-   [ ] Update `.env` untuk production settings
-   [ ] Set `APP_ENV=production`
-   [ ] Set `APP_DEBUG=false`
-   [ ] Generate production `APP_KEY`
-   [ ] Configure database credentials
-   [ ] Setup mail driver (untuk email verification)

#### Build Assets

```bash
npm run build
```

#### Optimize Laravel

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

#### Database

```bash
# Run migrations
php artisan migrate --force

# Seed roles (REQUIRED)
php artisan db:seed --class=RoleSeeder

# Optional: Seed sample data
php artisan db:seed
```

#### Web Server Configuration

**Nginx Example:**

```nginx
server {
    listen 80;
    server_name booking.yourdomain.com;
    root /var/www/booking/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Apache Example (.htaccess in public/):**

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [L]
</IfModule>
```

#### File Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Supervisor (Queue Worker - if using)

```ini
[program:booking-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/booking/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/booking/storage/logs/worker.log
```

### Deployment Platforms

#### Laravel Forge (Recommended)

1. Connect server
2. Create site
3. Deploy script auto-configured
4. Enable Quick Deploy for auto-deployment

#### Shared Hosting (cPanel)

1. Upload files via FTP/Git
2. Point domain to `public/` folder
3. Import database via phpMyAdmin
4. Update `.env` file
5. Run migrations via terminal/cron

#### Docker (Laravel Sail)

```bash
# Production Dockerfile included
docker-compose -f docker-compose.prod.yml up -d
```

---

## 📚 Usage Guide

### Untuk Admin

#### 1. Mengelola Ruangan

1. Login sebagai Admin
2. Sidebar → **Rooms**
3. Klik **Create Room** untuk tambah ruangan baru
4. Isi: Nama, Lokasi, Kapasitas
5. **Save** - Ruangan muncul di list

#### 2. Approve/Reject Booking

1. Sidebar → **Bookings**
2. Lihat list booking dengan status **Pending**
3. Klik **Approve** (hijau) atau **Reject** (merah)
4. Confirmation dialog → Konfirmasi
5. Status berubah, notifikasi sukses

#### 3. Cancel Booking (Force Cancel)

1. Sidebar → **Bookings**
2. Pilih booking apapun (approved/pending)
3. Klik **Cancel**
4. Confirmation dialog → Konfirmasi
5. Status berubah ke Cancelled

#### 4. Monitoring & Reports

1. Dashboard → View stats
    - Total bookings hari ini/minggu/bulan
    - Room utilization chart
    - Recent bookings
2. Filter by room/user/date untuk custom report

### Untuk Staff

#### 1. Membuat Booking

1. Login sebagai Staff
2. Sidebar → **Create Booking**
3. Pilih **waktu mulai** dan **waktu selesai**
4. Sistem auto-filter ruangan yang available
5. Klik **Book Sekarang** pada ruangan yang dipilih
6. Isi **catatan** (optional) di modal
7. **Buat Booking** → Status: Pending
8. Tunggu admin approve

#### 2. Lihat Booking Saya

1. Sidebar → **My Bookings**
2. Filter by status: All/Pending/Approved/Rejected/Cancelled
3. Lihat detail: Room, Waktu, Status, Catatan

#### 3. Edit Booking (Jika Pending)

1. My Bookings → Pilih booking **Pending**
2. Klik **Edit**
3. Ubah waktu/catatan
4. Sistem cek conflict otomatis
5. **Save** jika tidak ada conflict

#### 4. Cancel Booking (Jika Pending)

1. My Bookings → Pilih booking **Pending**
2. Klik **Cancel**
3. Confirmation dialog → Konfirmasi
4. Status berubah ke Cancelled
5. Ruangan available lagi untuk user lain

---

## 🐛 Troubleshooting

### Common Issues

#### 1. **Error: "Class 'Role' not found"**

**Solusi:**

```bash
php artisan db:seed --class=RoleSeeder
```

Role harus di-seed terlebih dahulu.

#### 2. **Conflict detection tidak bekerja**

**Solusi:**

-   Pastikan booking yang bentrok berstatus `approved`
-   Check index database: `room_id`, `start_time`, `end_time`
-   Test dengan query manual:

```sql
SELECT * FROM bookings
WHERE room_id = 1
  AND status = 'approved'
  AND start_time < '2025-12-22 15:00:00'
  AND end_time > '2025-12-22 14:00:00';
```

#### 3. **Assets tidak load (404)**

**Solusi:**

```bash
npm run build
php artisan storage:link
```

#### 4. **Email verification error**

**Solusi:**
Configure mail driver di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io  # or your SMTP
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

Untuk development, gunakan Mailtrap atau Log driver.

#### 5. **Permission denied untuk storage/logs**

**Solusi:**

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

#### 6. **Tests gagal: Database seeding**

**Solusi:**
Pastikan `.env.testing` configured:

```env
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

---

## 🔮 Future Enhancements

### Planned Features (Roadmap)

#### Phase 2: Notifications

-   [ ] **Email Notifications**
    -   Booking approved/rejected
    -   Booking reminder (1 day before)
    -   Admin notification untuk new booking
-   [ ] **Push Notifications** (via Firebase/Pusher)
-   [ ] **In-app Notifications** dengan badge counter

#### Phase 3: Advanced Booking

-   [ ] **Recurring Bookings**
    -   Daily/Weekly/Monthly patterns
    -   Bulk create dengan conflict check
-   [ ] **Booking Templates**
    -   Save frequently used booking settings
    -   Quick book dengan template
-   [ ] **Equipment/Amenities**
    -   Projector, whiteboard, video conference
    -   Filter rooms by amenities

#### Phase 4: Integration

-   [ ] **Calendar Export** (iCal format)
-   [ ] **Google Calendar Sync**
-   [ ] **Microsoft Outlook Integration**
-   [ ] **Slack/Discord Webhooks**

#### Phase 5: Analytics & Reporting

-   [ ] **Advanced Analytics Dashboard**
    -   Peak hours heatmap
    -   Room utilization trends
    -   User booking patterns
-   [ ] **Export Reports** (PDF, Excel)
-   [ ] **Custom Date Range Reports**

#### Phase 6: Mobile

-   [ ] **Progressive Web App (PWA)**
-   [ ] **Mobile App** (React Native/Flutter)
-   [ ] **QR Code Check-in**

---

## 👨‍💻 Development

### Local Development Setup

#### Using Laravel Herd (Recommended for Mac/Windows)

```bash
# Install Herd from https://herd.laravel.com
# Navigate to project folder
cd sistem-booking-ruangan

# Access via browser
http://sistem-booking-ruangan.test
```

#### Using Laravel Sail (Docker)

```bash
# Start Docker containers
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate

# Access via browser
http://localhost
```

#### Using PHP Built-in Server

```bash
php artisan serve
# Access: http://localhost:8000
```

### Code Style & Standards

#### PHP (Laravel Pint)

```bash
# Check code style
./vendor/bin/pint --test

# Fix code style
./vendor/bin/pint
```

#### JavaScript (ESLint - if configured)

```bash
npm run lint
npm run lint:fix
```

### Git Workflow

```bash
# Create feature branch
git checkout -b feature/nama-fitur

# Make changes, commit
git add .
git commit -m "feat: add feature X"

# Push to remote
git push origin feature/nama-fitur

# Create Pull Request di GitHub
```

**Commit Convention:**

-   `feat:` - New feature
-   `fix:` - Bug fix
-   `docs:` - Documentation
-   `style:` - Code style (formatting)
-   `refactor:` - Code refactoring
-   `test:` - Add/update tests
-   `chore:` - Maintenance tasks

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🙏 Acknowledgements

### Technologies Used

-   [Laravel](https://laravel.com) - The PHP Framework for Web Artisans
-   [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS framework
-   [Alpine.js](https://alpinejs.dev) - Lightweight JavaScript framework
-   [Chart.js](https://chartjs.org) - Simple yet flexible charting library
-   [SweetAlert2](https://sweetalert2.github.io) - Beautiful modal dialogs
-   [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) - Role & Permission management
-   [Pest PHP](https://pestphp.com) - Elegant PHP testing framework

### Learning Resources

-   [Laravel Documentation](https://laravel.com/docs)
-   [Laracasts](https://laracasts.com)
-   [Laravel Daily](https://laraveldaily.com)
-   [Spatie Blog](https://spatie.be/blog)

---

## 📞 Contact & Support

**Developer:** [Your Name]
**Email:** your.email@example.com
**GitHub:** [@Brynnnn12](https://github.com/Brynnnn12)
**Portfolio:** [your-portfolio.com]

### Contributing

Contributions, issues, and feature requests are welcome!
Feel free to check [issues page](https://github.com/Brynnnn12/sistem-booking-ruangan/issues).

### Show your support

Give a ⭐️ if this project helped you!

---

## 📝 Changelog

### [1.0.0] - 2025-12-22

#### Added

-   ✅ Initial release
-   ✅ Authentication dengan Laravel Breeze
-   ✅ Role-based access control (Admin/Staff)
-   ✅ Room management (CRUD)
-   ✅ Booking management dengan approval workflow
-   ✅ Real-time conflict detection
-   ✅ Responsive UI dengan Tailwind CSS
-   ✅ Interactive features dengan Alpine.js
-   ✅ Charts dengan Chart.js
-   ✅ Beautiful alerts dengan SweetAlert2
-   ✅ Comprehensive testing (21 test cases)
-   ✅ Repository-Service pattern
-   ✅ Policy-based authorization

---

<div align="center">

**Built with ❤️ using Laravel 12**

[⬆ Back to top](#-meeting-room-booking-system)

</div>
