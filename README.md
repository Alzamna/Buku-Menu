# Sistem Menu Restoran - CodeIgniter 4

Sistem menu restoran digital yang memungkinkan pelanggan memesan makanan melalui QR Code atau link langsung. Dibangun dengan CodeIgniter 4, Bootstrap 5, dan MySQL.

## 🚀 Fitur Utama

### Super Admin
- ✅ Mengelola semua restoran (CRUD)
- ✅ Membuat akun admin restoran
- ✅ Dashboard dengan statistik

### Admin Restoran
- ✅ Mengelola kategori menu
- ✅ Mengelola menu produk (nama, harga, deskripsi, gambar, stok)
- ✅ Generate QR Code untuk menu pelanggan
- ✅ Mengelola pesanan pelanggan
- ✅ Dashboard dengan statistik restoran

### Pelanggan (Public Access)
- ✅ Melihat menu restoran via QR Code/link
- ✅ Memilih produk dengan jumlah dan catatan
- ✅ Keranjang belanja
- ✅ Checkout dengan pilihan dine in/take away
- ✅ Detail pesanan

## 🛠️ Teknologi

- **Framework**: CodeIgniter 4
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Font Awesome
- **QR Code**: Endroid/QrCode
- **PHP**: 8.1+

## 📋 Struktur Database

### Tabel `users`
- `id` (Primary Key)
- `username` (Unique)
- `password` (Hashed)
- `role` (super_admin/admin_restoran)
- `restoran_id` (Foreign Key)
- `created_at`, `updated_at`

### Tabel `restoran`
- `id` (Primary Key)
- `nama`
- `alamat`
- `kontak`
- `created_at`, `updated_at`

### Tabel `kategori`
- `id` (Primary Key)
- `nama`
- `restoran_id` (Foreign Key)
- `created_at`, `updated_at`

### Tabel `menu`
- `id` (Primary Key)
- `nama`
- `harga`
- `kategori_id` (Foreign Key)
- `gambar`
- `deskripsi`
- `stok`
- `created_at`, `updated_at`

### Tabel `pesanan`
- `id` (Primary Key)
- `restoran_id` (Foreign Key)
- `metode` (dine_in/take_away)
- `total`
- `waktu_pesan`
- `status` (pending/confirmed/completed/cancelled)
- `created_at`, `updated_at`

### Tabel `pesanan_detail`
- `id` (Primary Key)
- `pesanan_id` (Foreign Key)
- `menu_id` (Foreign Key)
- `jumlah`
- `harga_satuan`
- `subtotal`
- `catatan`
- `created_at`, `updated_at`

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd Buku-Menu
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Database
1. Buat database MySQL baru
2. Copy file `env` ke `.env`
3. Edit file `.env`:
```env
database.default.hostname = localhost
database.default.database = nama_database_anda
database.default.username = username_database_anda
database.default.password = password_database_anda
```

### 4. Jalankan Migration
```bash
php spark migrate
```

### 5. Jalankan Seeder
```bash
php spark db:seed InitialDataSeeder
```

### 6. Buat Folder Upload
```bash
mkdir public/uploads/menu
chmod 777 public/uploads/menu
```

### 7. Jalankan Server
```bash
php spark serve
```

## 👤 Akun Default

### Super Admin
- **Username**: `superadmin`
- **Password**: `superadmin123`

### Admin Restoran
- **Username**: `admin`
- **Password**: `admin123`

## 📱 Cara Penggunaan

### Untuk Super Admin
1. Login dengan akun super admin
2. Tambah restoran baru
3. Buat akun admin untuk restoran tersebut
4. Monitor semua restoran dari dashboard

### Untuk Admin Restoran
1. Login dengan akun admin restoran
2. Tambah kategori menu (Makanan, Minuman, dll)
3. Tambah menu dengan gambar dan detail
4. Generate QR Code untuk menu pelanggan
5. Monitor pesanan pelanggan

### Untuk Pelanggan
1. Scan QR Code atau buka link menu
2. Pilih menu yang diinginkan
3. Masukkan jumlah dan catatan
4. Tambah ke keranjang
5. Checkout dengan pilihan dine in/take away
6. Lihat detail pesanan

## 🔧 Konfigurasi Tambahan

### QR Code
Sistem menggunakan library Endroid/QrCode untuk generate QR Code. QR Code akan mengarahkan ke URL menu pelanggan.

### Upload Gambar
- Folder upload: `public/uploads/menu/`
- Format yang didukung: JPG, PNG, GIF
- Maksimal ukuran: 2MB

### Session
Sistem menggunakan session untuk menyimpan keranjang belanja pelanggan.

## 📁 Struktur Folder

```
Buku-Menu/
├── app/
│   ├── Config/
│   ├── Controllers/
│   │   ├── Admin.php
│   │   ├── Auth.php
│   │   ├── Customer.php
│   │   ├── QRCodeController.php
│   │   └── SuperAdmin.php
│   ├── Database/
│   │   ├── Migrations/
│   │   └── Seeds/
│   ├── Filters/
│   ├── Models/
│   └── Views/
│       ├── admin/
│       ├── auth/
│       ├── customer/
│       ├── layouts/
│       └── super_admin/
├── public/
│   └── uploads/
└── writable/
```

## 🐛 Troubleshooting

### Error Database
- Pastikan database sudah dibuat
- Periksa konfigurasi di file `.env`
- Jalankan `php spark migrate:status` untuk cek status migration

### Error Upload Gambar
- Pastikan folder `public/uploads/menu/` sudah dibuat
- Periksa permission folder (777)
- Pastikan format file didukung

### Error QR Code
- Pastikan library Endroid/QrCode sudah terinstall
- Jalankan `composer install` ulang

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.

## 📄 License

MIT License - silakan gunakan untuk keperluan komersial maupun non-komersial.

---

**Dibuat dengan ❤️ menggunakan CodeIgniter 4**
