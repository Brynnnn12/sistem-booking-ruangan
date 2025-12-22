# Meeting Room Booking System

## Project Brief & Agile Sprint Plan

---

## 📋 PROJECT BRIEF

### Project Overview

Sistem booking ruang meeting internal untuk kantor/organisasi yang menangani pemesanan ruang rapat, pengecekan konflik jadwal otomatis, dan manajemen berbasis role. Sistem ini dirancang sebagai solusi digital-first yang realistis dan dapat diterapkan di startup, kantor, atau organisasi.

### Business Problem

-   **Konflik jadwal** saat beberapa tim memesan ruang yang sama
-   **Tidak ada tracking** siapa memakai ruang kapan
-   **Manual coordination** via chat/email yang tidak efisien
-   **Tidak ada audit trail** untuk penggunaan ruang

### Target Users

1. **Admin** - Mengelola master data ruang dan supervisi semua booking
2. **Staff/Employee** - Pengguna yang melakukan booking untuk kebutuhan meeting

### Success Metrics

-   Waktu booking < 2 menit
-   Zero konflik jadwal (validasi otomatis 100%)
-   Audit trail lengkap untuk compliance
-   Adoption rate > 80% dalam 2 minggu

---

## 🎯 SCOPE & FEATURES

### ✅ In Scope (v1)

-   Authentication & Authorization (Laravel Breeze + Spatie Permission)
-   Master data ruang meeting
-   Booking dengan conflict checking real-time
-   Cancel booking dengan policy-based access
-   Booking history & audit trail
-   Role-based dashboard

### ❌ Out of Scope (Future)

-   Email/Push notification
-   Recurring booking
-   Kalender eksternal (Google Calendar, Outlook)
-   Approval workflow
-   Room amenities tracking
-   Mobile app

---

## 🗂️ TECHNICAL SPECIFICATION

### Tech Stack

-   **Backend**: Laravel 11+ (PHP 8.2+)
-   **Auth**: Laravel Breeze
-   **Permission**: Spatie Laravel Permission
-   **Database**: MySQL 8.0+
-   **Frontend**: Blade + Tailwind CSS (minimal)

### Database Schema

**Table: users**

```
id (PK)
name
email
password
role (enum: 'admin', 'staff')
created_at, updated_at
```

**Table: rooms**

```
id (PK)
name (string)
location (string)
capacity (int)
is_active (boolean, default: true)
created_at, updated_at
```

**Table: bookings**

```
id (PK)
room_id (FK → rooms.id)
user_id (FK → users.id)
title (string)
start_time (datetime)
end_time (datetime)
status (enum: 'booked', 'cancelled')
cancelled_at (datetime, nullable)
cancelled_by (FK → users.id, nullable)
created_at, updated_at
```

### Business Rules

| Rule                        | Implementation                                                                             |
| --------------------------- | ------------------------------------------------------------------------------------------ |
| **No Overlapping Bookings** | Query check: `WHERE room_id = ? AND status = 'booked' AND start_time < ? AND end_time > ?` |
| **Booking Duration**        | Min: 30 minutes, Max: 8 hours                                                              |
| **Booking Time Window**     | Max 30 hari ke depan                                                                       |
| **Cancel Policy - Staff**   | Hanya booking sendiri (user_id match)                                                      |
| **Cancel Policy - Admin**   | Semua booking                                                                              |
| **Immutable History**       | Soft delete via status, bukan hard delete                                                  |

---

## 🚀 AGILE SPRINT PLANNING

### Apa itu Metode Agile dan Scrum?

**Agile** adalah metodologi pengembangan perangkat lunak yang fleksibel, iteratif, dan kolaboratif. Berbeda dengan metode waterfall yang kaku, Agile memungkinkan adaptasi cepat terhadap perubahan. **Scrum** adalah framework Agile yang paling populer, yang membagi pekerjaan menjadi siklus pendek bernama "Sprint".

Dalam proyek ini, kita menggunakan **Scrum** dengan elemen-elemen berikut:

-   **Sprint**: Periode waktu tetap (2 minggu) untuk menyelesaikan tugas tertentu.
-   **User Stories**: Deskripsi fitur dari perspektif pengguna (format: "As a [role], I want [feature] so that [benefit]").
-   **Acceptance Criteria**: Kriteria yang harus dipenuhi agar story dianggap selesai.
-   **Definition of Done (DoD)**: Standar untuk menyatakan sprint selesai.
-   **Retrospective**: Refleksi di akhir sprint untuk perbaikan.

**Mengapa Agile untuk Proyek Ini?**

-   Proyek kecil (1 developer), cocok untuk iterasi cepat.
-   Memungkinkan feedback dini dan penyesuaian.
-   Fokus pada value delivery, bukan dokumentasi berlebihan.

### Alur Proyek Secara Keseluruhan

1. **Planning & Setup** (Week 1): Analisis kebutuhan, setup environment, inisialisasi proyek.
2. **Sprint 1** (Week 1-2): Foundation - Auth, roles, room CRUD.
3. **Sprint 2** (Week 3-4): Core Logic - Booking, conflict checking, cancel policies.
4. **Sprint 3** (Week 5-6): Polish - Dashboard, UI/UX, documentation.
5. **Testing & Deployment** (Week 7): Final testing, deploy, retrospective.

**Diagram Alur Sederhana:**

```
Planning → Sprint 1 → Review → Sprint 2 → Review → Sprint 3 → Review → Deploy
     ↓         ↓            ↓         ↓            ↓         ↓         ↓
  Setup    Foundation   Retro     Core Logic    Retro    Polish    Retro   Launch
```

### Sprint Overview

-   **Sprint Duration**: 2 minggu per sprint (time-boxed, tidak bisa diperpanjang).
-   **Total Sprints**: 3 sprints (sesuai scope v1).
-   **Team**: 1 Backend Developer (you) - sebagai Product Owner, Developer, dan Tester.
-   **Working Hours**: ~20 jam/sprint (realistis untuk 1 orang).
-   **Ceremonies**: Daily standup (harian, 15 menit), Sprint Review (akhir sprint), Retrospective.

---

## 🏃 SPRINT 1: Foundation & Authentication (Week 1-2)

### Sprint Goal

Setup project, authentication, dan database foundation yang solid untuk membangun sistem booking yang aman dan terstruktur.

### Alur Sprint 1 (Langkah demi Langkah)

1. **Hari 1-2: Setup Project** - Install Laravel, Breeze, configure database, init Git.
2. **Hari 3-4: Implementasi Auth & Roles** - Setup Spatie Permission, buat middleware, seed roles.
3. **Hari 5-7: Room CRUD** - Buat migration, model, controller, views untuk admin manage rooms.
4. **Hari 8-10: Room Listing untuk Staff** - Buat route public, view sederhana dengan filter.
5. **Hari 11-14: Testing & Polish** - Manual testing, fix bugs, update README.

### User Stories

**US-1.1: Setup Project**

```
As a Developer
I want to setup Laravel project dengan auth
So that project structure sudah siap untuk development

Acceptance Criteria:
- Laravel 10 installed
- Laravel Breeze installed & configured
- Database migration ready
- Git repository initialized

Estimate: 2 hours
```

**US-1.2: User Management & Roles**

```
As a System
I want to implement role-based access control
So that admin dan staff memiliki akses yang berbeda

Acceptance Criteria:
- Spatie Permission installed
- Role 'admin' dan 'staff' seeded
- Middleware untuk protect routes
- Test user untuk masing-masing role

Estimate: 3 hours
```

**US-1.3: Room Master Data**

```
As an Admin
I want to manage meeting rooms (CRUD)
So that staff dapat melihat ruang yang tersedia

Acceptance Criteria:
- Migration table rooms
- CRUD controller & views (admin only)
- Validation: name, location required; capacity min 1
- Seeder dengan 5 contoh ruang

Estimate: 5 hours
```

**US-1.4: Room List for Staff**

```
As a Staff
I want to view available meeting rooms
So that saya tahu ruang mana yang bisa di-booking

Acceptance Criteria:
- Public route untuk list rooms
- Filter by capacity (optional)
- Show: name, location, capacity
- Simple Blade view dengan Tailwind

Estimate: 3 hours
```

### Sprint 1 Deliverables

-   ✅ Laravel project dengan auth
-   ✅ Role-based access control
-   ✅ Room CRUD (admin)
-   ✅ Room listing (staff)

**Total Estimate: 13 hours**

### Definition of Done (Sprint 1)

-   [x] Code di push ke GitHub
-   [x] Migration & seeder berjalan tanpa error
-   [x] Manual testing passed untuk semua user stories
-   [x] README updated dengan setup instruction

---

## ✅ SPRINT 1 COMPLETED: Foundation & Authentication

**Status**: ✅ **SELESAI** (Rooms CRUD & Testing)

### Yang Sudah Diimplementasi

**US-1.1: Setup Project** ✅

-   Laravel 11 installed dengan PHP 8.2+
-   Laravel Breeze installed & configured
-   Database MySQL configured
-   Git repository initialized

**US-1.2: User Management & Roles** ✅

-   Spatie Permission installed & configured
-   Role 'Admin' dan 'Staff' seeded
-   Middleware role-based access control
-   MustVerifyEmail trait activated untuk email verification

**US-1.3: Room Master Data** ✅

-   Migration table `rooms` (name, location, capacity, is_active)
-   CRUD controller & views (admin only via policy)
-   Validation: name/location required, capacity min 1
-   Seeder dengan contoh ruang
-   Policy RoomPolicy untuk role-based access

**US-1.4: Room List for Staff** ✅

-   Route `/dashboard/rooms` untuk list rooms
-   Filter by capacity (optional)
-   View dengan Blade + Tailwind CSS
-   Role-based access: Admin CRUD, Staff view only

### Testing Coverage ✅

-   Feature tests untuk RoomTest.php (9 test cases)
-   Coverage: Guest access, Email verification, Admin/Staff permissions
-   Conflict checking logic ready untuk Sprint 2

### Next: Sprint 2 - Booking Core Logic

Siap untuk implementasi booking dengan conflict checking.

## 🏃 SPRINT 2: Booking Core Logic (Week 3-4)

### Sprint Goal

Implementasi core booking dengan conflict checking dan cancel policy untuk memastikan sistem booking berjalan lancar tanpa konflik.

### Alur Sprint 2 (Langkah demi Langkah)

1. **Hari 1-3: Create Booking Form** - Buat form booking dengan validasi dasar (time, duration).
2. **Hari 4-7: Conflict Checking Logic** - Implementasi query overlap, error handling, unit test.
3. **Hari 8-9: My Bookings View** - Buat halaman history booking dengan filter.
4. **Hari 10-12: Cancel Policies** - Implementasi cancel untuk staff (own booking) dan admin (all).
5. **Hari 13-14: Integration Testing** - Test end-to-end, fix edge cases.

### User Stories

**US-2.1: Create Booking**

```
As a Staff
I want to book a meeting room
So that saya punya ruang untuk meeting

Acceptance Criteria:
- Form booking: room_id, title, start_time, end_time
- Validation: end_time > start_time, min 30 min, max 8 jam
- Validation: max 30 hari ke depan
- Status default = 'booked'
- Success message & redirect

Estimate: 4 hours
```

**US-2.2: Conflict Checking**

```
As a System
I want to prevent overlapping bookings
So that tidak ada double booking

Acceptance Criteria:
- Query check overlap BEFORE save
- Error message jelas jika bentrok
- Show waktu bentrok untuk user clarity
- Unit test untuk conflict logic

Estimate: 5 hours
```

**US-2.3: My Bookings**

```
As a Staff
I want to see my booking history
So that saya tahu kapan saja saya booking

Acceptance Criteria:
- Route /my-bookings (staff only)
- Show: room name, title, waktu, status
- Filter by status (all, booked, cancelled)
- Order by start_time DESC

Estimate: 3 hours
```

**US-2.4: Cancel Booking (Staff)**

```
As a Staff
I want to cancel my own booking
So that ruang bisa digunakan orang lain

Acceptance Criteria:
- Button cancel hanya muncul untuk booking sendiri
- Status berubah jadi 'cancelled'
- cancelled_at & cancelled_by ter-record
- Policy check: hanya user_id match

Estimate: 3 hours
```

**US-2.5: Cancel Booking (Admin)**

```
As an Admin
I want to cancel any booking
So that saya bisa handle kasus darurat

Acceptance Criteria:
- Admin bisa cancel semua booking
- Reason/note untuk cancel (optional)
- Same recording logic (cancelled_at, cancelled_by)

Estimate: 2 hours
```

### Sprint 2 Deliverables

-   ✅ Booking creation dengan validasi
-   ✅ Conflict checking 100% accurate
-   ✅ My bookings view
-   ✅ Cancel booking dengan policy

**Total Estimate: 17 hours**

### Definition of Done (Sprint 2)

-   [ ] Conflict checking tested dengan edge cases
-   [ ] Policy testing: staff tidak bisa cancel booking orang lain
-   [ ] Admin bisa cancel semua booking
-   [ ] Code review internal (self-review)

---

## 🏃 SPRINT 3: Dashboard & Polish (Week 5-6)

### Sprint Goal

Dashboard untuk monitoring, UI polish, dan documentation untuk menyelesaikan produk yang siap pakai dan presentable.

### Alur Sprint 3 (Langkah demi Langkah)

1. **Hari 1-3: Admin Dashboard** - Buat stats, recent bookings, filter, export CSV.
2. **Hari 4-5: Staff Dashboard** - Upcoming bookings, quick book button, room availability.
3. **Hari 6-7: Booking Detail View** - Halaman detail booking dengan history dan actions.
4. **Hari 8-10: UI Polish** - Flash messages, validation in Bahasa Indonesia, responsive design.
5. **Hari 11-14: Documentation & Deployment** - Update README, .env.example, deployment guide.

### User Stories

**US-3.1: Admin Dashboard**

```
As an Admin
I want to see all bookings overview
So that saya bisa monitor penggunaan ruang

Acceptance Criteria:
- Stats: total bookings hari ini, minggu ini, bulan ini
- Recent bookings (latest 10)
- Filter by room, date range
- Export to CSV (bonus)

Estimate: 5 hours
```

**US-3.2: Staff Dashboard**

```
As a Staff
I want to see upcoming bookings
So that saya tahu jadwal meeting saya

Acceptance Criteria:
- Upcoming bookings (today & next 7 days)
- Quick booking button
- Room availability today (simple view)

Estimate: 3 hours
```

**US-3.3: Booking Detail View**

```
As a User
I want to see booking details
So that saya tahu informasi lengkap booking

Acceptance Criteria:
- Detail page /bookings/{id}
- Show: title, room, user, waktu, status
- History log (jika ada cancel)
- Back button & action buttons (cancel, jika allowed)

Estimate: 3 hours
```

**US-3.4: UI Polish & Validation Messages**

```
As a User
I want clear feedback untuk setiap action
So that saya tidak bingung saat menggunakan sistem

Acceptance Criteria:
- Flash messages untuk success/error
- Validation error messages dalam Bahasa Indonesia
- Loading state untuk form submission
- Responsive layout (mobile friendly)

Estimate: 4 hours
```

**US-3.5: Documentation & Deployment**

```
As a Developer
I want to create comprehensive documentation
So that recruiter/team bisa understand project ini

Acceptance Criteria:
- README.md lengkap (setup, features, screenshots)
- API documentation (jika ada)
- .env.example updated
- Deployment guide (Laravel Forge / Heroku / VPS)

Estimate: 3 hours
```

### Sprint 3 Deliverables

-   ✅ Admin & Staff dashboard
-   ✅ Booking detail view
-   ✅ UI polish & UX improvement
-   ✅ Complete documentation

**Total Estimate: 18 hours**

### Definition of Done (Sprint 3)

-   [ ] All features tested end-to-end
-   [ ] Documentation complete
-   [ ] Deployed to staging/production
-   [ ] Demo video/screenshots ready untuk portfolio

---

## 🧪 TESTING STRATEGY

### Manual Testing Checklist

**Authentication & Authorization**

-   [ ] Login sebagai admin
-   [ ] Login sebagai staff
-   [ ] Akses admin-only routes sebagai staff (harus ditolak)

**Room Management**

-   [ ] CRUD operations (admin)
-   [ ] Validation error handling

**Booking Flow**

-   [ ] Create booking (happy path)
-   [ ] Create booking dengan waktu bentrok (error)
-   [ ] Create booking dengan invalid time (error)
-   [ ] Cancel own booking (staff)
-   [ ] Cancel any booking (admin)

**Edge Cases**

-   [ ] Booking di hari yang sama, jam berbeda
-   [ ] Booking di ruang berbeda, waktu sama
-   [ ] Cancel booking yang sudah cancelled

### Unit Test (Optional untuk v1, Good to Have)

```php
// tests/Unit/BookingConflictTest.php
public function test_booking_conflict_detection()
{
    // Given: Ada booking existing 10:00-11:00
    // When: Create booking baru 10:30-11:30
    // Then: Harus error conflict
}
```

---

## 📊 PROJECT TIMELINE

### Alur Proyek Detail (Week by Week)

**Week 1: Planning & Sprint 1 Start**

-   Analisis kebutuhan bisnis
-   Setup environment (Laravel, DB, Git)
-   Mulai Sprint 1: Auth & Roles

**Week 2: Sprint 1 End & Review**

-   Selesai Room CRUD & Listing
-   Sprint Review: Demo features
-   Retrospective: Apa yang baik, apa yang perlu diperbaiki

**Week 3: Sprint 2 Start**

-   Planning Sprint 2
-   Implementasi Booking Creation & Validation

**Week 4: Sprint 2 End & Review**

-   Conflict Checking, My Bookings, Cancel Policies
-   Testing edge cases
-   Sprint Review & Retrospective

**Week 5: Sprint 3 Start**

-   Planning Sprint 3
-   Admin & Staff Dashboards

**Week 6: Sprint 3 End & Review**

-   UI Polish, Documentation
-   Final testing
-   Sprint Review & Retrospective

**Week 7: Buffer & Deployment**

-   Bug fixes jika ada
-   Deploy to staging/production
-   Final demo & documentation

### Diagram Timeline

```
Week 1     Week 2     Week 3     Week 4     Week 5     Week 6     Week 7
│          │          │          │          │          │          │
├─Sprint 1─┼─Review───┼─Sprint 2─┼─Review───┼─Sprint 3─┼─Review───┼─Deploy──┤
│          │          │          │          │          │          │
└─Planning─┴─Auth─────┴─Booking──┴─Core─────┴─Dashboard┴─Polish───┴─Launch──┘
```

**Total Duration**: 7 minggu (6 minggu development + 1 minggu buffer)

---

## 🎨 UI/UX GUIDELINES

### Design Principles

-   **Simple First**: Fokus pada functionality, bukan fancy UI
-   **Clear Feedback**: Success/error messages yang jelas
-   **Minimal Clicks**: Max 3 clicks untuk booking

### Key Screens

**1. Dashboard (Staff)**

-   Upcoming bookings (card layout)
-   Quick book button (prominent)
-   Available rooms today (simple list)

**2. Room List**

-   Grid/list view dengan filter
-   Kapasitas & lokasi visible
-   "Book Now" button per room

**3. Booking Form**

-   Room selection (dropdown/radio)
-   Date & time picker (native HTML5 atau flatpickr)
-   Title input
-   Clear validation messages

**4. My Bookings**

-   Table layout: Room | Title | Time | Status | Action
-   Filter tabs: All | Active | Cancelled
-   Cancel button dengan confirmation

---

## 🚢 DEPLOYMENT CHECKLIST

### Pre-deployment

-   [ ] .env.example updated
-   [ ] Database migration & seeder tested
-   [ ] Composer dependencies optimized
-   [ ] Config cache cleared

### Production Setup

-   [ ] Set APP_ENV=production
-   [ ] Set APP_DEBUG=false
-   [ ] Configure APP_URL
-   [ ] Setup database credentials
-   [ ] Run migrations
-   [ ] Run seeders (admin user)

### Post-deployment

-   [ ] Test login (admin & staff)
-   [ ] Test booking flow end-to-end
-   [ ] Check error logs
-   [ ] Setup backup (database)

---

## 📝 PORTFOLIO PRESENTATION

### GitHub README Structure

```markdown
# Meeting Room Booking System

> Internal booking system dengan conflict checking & role-based access

## 🎯 Key Features

-   Real-time conflict detection
-   Role-based access control (Admin/Staff)
-   Booking history & audit trail
-   Policy-based cancellation

## 🛠️ Tech Stack

-   Laravel 10 | PHP 8.2
-   MySQL | Tailwind CSS
-   Spatie Permission

## 📸 Screenshots

[Dashboard] [Booking Form] [Conflict Detection]

## 🚀 Installation

[Step-by-step guide]

## 💡 Business Logic Highlights

[Explain conflict checking algorithm]
```

### Demo Talking Points

1. **Problem Statement**: "Kantor sering bentrok booking ruang meeting"
2. **Solution**: "Sistem validasi otomatis yang prevent double booking"
3. **Technical Highlight**: "Implementasi query optimization untuk conflict checking"
4. **Business Value**: "Hemat waktu koordinasi, audit trail untuk compliance"

---

## 🎓 LEARNING OUTCOMES

Setelah menyelesaikan project ini, kamu akan memiliki:

### Technical Skills

-   ✅ Laravel best practices (Eloquent, Validation, Policies)
-   ✅ Database design untuk booking system
-   ✅ Role-based access control implementation
-   ✅ Complex query untuk conflict detection

### Business Skills

-   ✅ Understanding real-world workflow
-   ✅ User story writing
-   ✅ Sprint planning & estimation

### Portfolio Value

-   ✅ Production-ready code
-   ✅ Clear documentation
-   ✅ Demo-able features
-   ✅ Talking points untuk interview

---

## 📚 RESOURCES

### Laravel Documentation

-   [Eloquent Relationships](https://laravel.com/docs/10.x/eloquent-relationships)
-   [Authorization](https://laravel.com/docs/10.x/authorization)
-   [Validation](https://laravel.com/docs/10.x/validation)

### Packages

-   [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v5/introduction)
-   [Laravel Breeze](https://laravel.com/docs/10.x/starter-kits#breeze)

### Best Practices

-   [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
-   [Database Design for Booking Systems](https://stackoverflow.com/questions/tagged/booking-system)

---

## ✅ SPRINT RETROSPECTIVE TEMPLATE

Gunakan setelah setiap sprint:

### What Went Well?

-   [ ] Features completed on time
-   [ ] No major blockers

### What Needs Improvement?

-   [ ] Time estimation accuracy
-   [ ] Testing coverage

### Action Items

-   [ ] Add unit tests (next sprint)
-   [ ] Improve documentation

---

## � RESOURCES

### Laravel Documentation

-   [Eloquent Relationships](https://laravel.com/docs/11.x/eloquent-relationships)
-   [Authorization](https://laravel.com/docs/11.x/authorization)
-   [Validation](https://laravel.com/docs/11.x/validation)

### Packages

-   [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
-   [Laravel Breeze](https://laravel.com/docs/11.x/starter-kits#breeze)

### Best Practices

-   [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
-   [Database Design for Booking Systems](https://stackoverflow.com/questions/tagged/booking-system)

---

## ✅ SPRINT RETROSPECTIVE TEMPLATE

Gunakan setelah setiap sprint:

### What Went Well?

-   [x] Features completed on time
-   [x] No major blockers
-   [x] Testing coverage baik (9/9 tests pass)

### What Needs Improvement?

-   [ ] Time estimation accuracy
-   [ ] Testing coverage

### Action Items

-   [ ] Add unit tests (next sprint)
-   [ ] Improve documentation

---
