# Sistem Gudang - Backend Laravel

Backend sistem gudang berbasis Laravel untuk manajemen:

- Barang
- Barang Masuk
- Barang Keluar
- Kendaraan
- User & Permission

---

# Tech Stack

- Laravel 13
- MySQL
- PHP 8.3.30
- Composer version 2.9.4
- Node 22.22.0
- Laravel Breeze
- Blade

---

# Cara Menjalankan Project

## 1. Clone Repository

```bash
git clone <https://github.com/Riahulina/Sistem-Gudang>
```

---

## 2. Masuk ke Folder Project

```bash
cd nama-project
```

---

## 3. Install Dependency

```bash
composer install
```

---

## 4. Copy File .env

```bash
copy .env.example .env
```

---

## 5. Generate App Key

```bash
php artisan key:generate
```

---

# Konfigurasi Database

Buka file:

```env
.env
```

Lalu ubah bagian berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbsistemgudang
DB_USERNAME=root
DB_PASSWORD=
```

---

# Jalankan Migration

```bash
php artisan migrate
```

Jika ingin refresh database:

```bash
php artisan migrate:fresh
```

---

# Menjalankan Project

## Jalankan Laravel

```bash
php artisan serve
```

---

## Jalankan Vite

```bash
npm install
npm run dev
```

---

# Authentication

Project ini menggunakan:

```text
Laravel Breeze
```

Fitur:

- Login
- Register
- Logout
- Session Authentication

---

# Struktur Database

## Tabel Yang Sudah Tersedia

### users

Menyimpan data user:

- name
- username
- email
- role
- password

---

### permissions

Menyimpan permission sistem.

Contoh:

- create_barang
- create_barang_masuk
- create_barang_keluar
- create_kendaraan

---

### user_permissions

Relasi many-to-many antara:

- users
- permissions

---

### barangs

Menyimpan data barang:

- kode_barang
- nama_barang
- stok
- kategori
- satuan

---

### barang_masuks

Riwayat barang masuk.

---

### barang_keluars

Riwayat barang keluar.

---

### kendaraans

Menyimpan data kendaraan operasional.

---

# Relasi Database

## User

- hasMany Barang
- hasMany BarangMasuk
- hasMany BarangKeluar
- hasMany Kendaraan
- belongsToMany Permission

---

## Barang

- belongsTo User
- hasMany BarangMasuk
- hasMany BarangKeluar

---

## Permission

- belongsToMany User

---

# Authorization

Sistem menggunakan:

- role
- permission

Role:

- ktu
- admin

Permission menggunakan sistem checklist.

---

# Status Project Saat Ini

## Backend Yang Sudah Ada

- Migration
- Model
- Relationship
- Authentication Breeze
- Database Structure

---

## Yang Akan Dikerjakan Selanjutnya

- CRUD Barang
- CRUD Barang Masuk
- CRUD Barang Keluar
- CRUD Kendaraan
- Middleware Permission
- Dashboard
- API/Frontend Integration

---

# Catatan Untuk Frontend

Frontend dapat langsung menggunakan:

- authentication bawaan Laravel
- relasi database yang sudah tersedia

---
