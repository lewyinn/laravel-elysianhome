# 🛍️ Laravel E-Commerce App (ElysianHome)

Proyek ini adalah aplikasi e-commerce berbasis **Laravel 11** yang mendukung dua peran utama: **Admin** dan **User**. Admin dapat mengelola produk, kategori, dan pesanan, sementara User dapat melakukan pembelian produk melalui keranjang dan checkout dengan integrasi **Midtrans** untuk pembayaran.

![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Laravel](https://img.shields.io/badge/Laravel-11-red)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 🚀 Fitur Utama

- 🔐 Autentikasi (Login & Register) dengan middleware role
- 📦 Manajemen Produk & Kategori (CRUD oleh Admin)
- 🛒 Keranjang & Checkout (oleh User)
- 💳 Integrasi Pembayaran Midtrans (Snap API)
- 📑 Riwayat Pesanan & Invoice (PDF menggunakan `barryvdh/laravel-dompdf`)
- 🧑‍💼 Dashboard Admin & User Terpisah
- ⚙️ Pengaturan Profil & Password
- 📸 Browser Rendering menggunakan `spatie/browsershot`

---

## 🧱 Struktur Database

### 📄 Tabel-Tabel

#### `users`
| Kolom       | Tipe     | Keterangan               |
|-------------|----------|--------------------------|
| id          | bigint   | Primary key              |
| name        | string   | Nama lengkap             |
| email       | string   | Email unik               |
| password    | string   | Password terenkripsi     |
| role        | enum     | `admin` / `user`         |

#### `categories`
| Kolom | Tipe   | Keterangan     |
|-------|--------|----------------|
| id    | bigint | Primary key    |
| name  | string | Nama kategori  |
| slug  | string | URL friendly   |

#### `products`
| Kolom      | Tipe     | Keterangan              |
|------------|----------|-------------------------|
| id         | bigint   | Primary key             |
| name       | string   | Nama produk             |
| description| text     | Deskripsi produk        |
| price      | decimal  | Harga                   |
| stock      | integer  | Stok tersedia           |
| image      | string   | Path gambar             |
| category_id| bigint   | Relasi ke kategori      |

#### `carts`
| Kolom      | Tipe   | Keterangan            |
|------------|--------|-----------------------|
| id         | bigint | Primary key           |
| user_id    | bigint | Relasi ke users       |
| product_id | bigint | Relasi ke products    |
| quantity   | int    | Jumlah beli           |

#### `orders`
| Kolom      | Tipe     | Keterangan                      |
|------------|----------|-------------------------------|
| id         | bigint   | Primary key                     |
| user_id    | bigint   | Relasi ke users                 |
| status     | enum     | `pending`, `paid`, `cancelled` |
| total_price| decimal  | Total harga semua item          |

#### `order_items`
| Kolom      | Tipe     | Keterangan              |
|------------|----------|-------------------------|
| id         | bigint   | Primary key             |
| order_id   | bigint   | Relasi ke orders        |
| product_id | bigint   | Relasi ke products      |
| quantity   | int      | Jumlah beli             |
| price      | decimal  | Harga per item          |

#### `settings`
| Kolom   | Tipe     | Keterangan         |
|---------|----------|--------------------|
| user_id | bigint   | Relasi ke users    |
| address | string   | Alamat lengkap     |
| phone   | string   | Nomor telepon      |

---

## 🧭 Alur Sistem

### 👨‍💼 Admin
- Login → Dashboard Admin
- Menu Navigasi:
  - Kelola **Kategori**
  - Kelola **Produk**
  - Kelola **Pesanan** (ubah status saja)
  - Kelola **Pengguna**

### 👤 User
- Login → Halaman Home E-commerce
- Tambah produk ke **Keranjang**
- Klik **Checkout** → redirect ke Midtrans
  - **Berhasil** → redirect ke halaman sukses
  - **Gagal / Close** → kembali ke keranjang, status tetap `pending`
- Riwayat pembelian tersedia di menu **History**
  - Bisa bayar ulang jika status masih `pending`
  - Bisa download invoice (PDF) jika sudah `paid`
- Ubah informasi di halaman **Settings** (profil & password)

---

### 📽️ Demo Project

Lihat demo proyek ini di Google Drive:
[Demo Laravel E-Commerce App](https://drive.google.com/drive/folders/1vmHfVoRomH4Thd-aV3BOoakjROE7TEu_?usp=sharing)

---

## ⚙️ Instalasi

1. Clone repo ini:
   ```bash
   git clone https://github.com/lewyinn/laravel-elysianhome.git
   cd nama-proyek
   ```

2. Install dependensi:
   ```bash
   composer install
   npm install
   ```

3. Salin file `.env` dan konfigurasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Atur koneksi database di `.env`:
   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_db
   DB_USERNAME=your_user
   DB_PASSWORD=your_pass
   ```

5. Jalankan migrasi & seeder:
   ```bash
   php artisan migrate --seed
   ```

6. Jalankan server:
   ```bash
   php artisan serve
   ```

---

## 💳 Midtrans Configuration

1. Daftar akun di [Midtrans](https://midtrans.com).
2. Ambil `Server Key` dan `Client Key` dari dashboard.
3. Tambahkan di `.env`:
   ```dotenv
   MIDTRANS_SERVER_KEY=YourServerKey
   MIDTRANS_CLIENT_KEY=YourClientKey
   MIDTRANS_IS_PRODUCTION=false
   MIDTRANS_IS_SANDBOX=true
   MIDTRANS_IS_3DS=true
   ```

---

## 📋 Dependensi

Proyek ini menggunakan dependensi berikut:

- PHP: `^8.2`
- Laravel Framework: `^11.31`
- Laravel Tinker: `^2.9`
- Midtrans PHP: `^2.6` (untuk integrasi pembayaran)
- Barryvdh Laravel DomPDF: `*` (untuk generate PDF invoice)
- Spatie Browsershot: `^5.0` (untuk rendering browser)

Lihat detail di `composer.json`:
```json
"require": {
    "php": "^8.2",
    "barryvdh/laravel-dompdf": "*",
    "laravel/framework": "^11.31",
    "laravel/tinker": "^2.9",
    "midtrans/midtrans-php": "^2.6",
    "spatie/browsershot": "^5.0"
}
```

---

## 🛡️ Middleware & Routing

| Role    | Akses Menu                                 |
|-------  |--------------------------------------------|
| Guest   | Login, Register                            |
| Admin   | Dashboard, Category, Product, Order, Users |
| User    | Home, Cart, Checkout, History, Settings    |

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE). Silakan gunakan, kembangkan, dan modifikasi sesuai kebutuhan.

---

## 👤 Author

- Nama: Moch. Ridho Kurniawan
- Email: ridhokur102@gmail.com
- Instagram: @mrdhkrnwn

---

## 📷 Screenshot Project ElysianHome

### Dashboard Admin
![Dashboard Admin](https://github.com/user-attachments/assets/618a5985-c115-40ef-bb35-e5c6ddf8e4d4)

### Halaman Checkout User
![Checkout User](https://github.com/user-attachments/assets/939f16b3-1c31-4e68-83cf-c6473da0c701)

---
