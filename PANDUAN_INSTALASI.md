# Panduan Instalasi Sistem Manajemen Barang

Ikuti langkah-langkah di bawah ini untuk memasang aplikasi ini di komputer atau laptop lain.

## 1. Persiapan Awal (Prasyarat)
Pastikan komputer sudah terinstall:
- **XAMPP** (Versi PHP 8.2 ke atas)
- **Composer** (Untuk mengelola program PHP)
- **Node.js & NPM** (Untuk mengelola tampilan/aset)

## 2. Membuat Database
1. Buka XAMPP Control Panel, jalankan **Apache** dan **MySQL**.
2. Buka browser, masuk ke `localhost/phpmyadmin`.
3. Buat database baru dengan nama: `menejeman_barang`.

## 3. Menyiapkan Folder Project
1. Copy folder project ini ke komputer tujuan (biasanya di `C:\xampp\htdocs\`).
2. Buka Terminal atau Command Prompt di dalam folder project tersebut.

## 4. Install Library / Dependency
Jalankan perintah berikut secara berurutan:
```bash
# Install library PHP
composer install

# Install library Tampilan
npm install
```

## 5. Konfigurasi File .env
1. Cari file bernama `.env.example`.
2. Copy file tersebut dan ubah namanya menjadi `.env`.
3. Buka file `.env` dengan Notepad/VSCode, pastikan bagian ini sesuai:
```env
DB_DATABASE=menejeman_barang
DB_USERNAME=root
DB_PASSWORD=
```
4. Jalankan perintah ini untuk membuat kunci keamanan:
```bash
php artisan key:generate
```

## 6. Migrasi Database & Data Awal
Gunakan perintah ini untuk membuat tabel otomatis dan mengisi data user awal:
```bash
php artisan migrate:fresh --seed
```

## 7. Build Aset Tampilan
Jalankan perintah ini agar tampilan Tailwind CSS muncul dengan benar:
```bash
npm run build
```

## 8. Menjalankan Aplikasi
Terakhir, jalankan aplikasi dengan perintah:
```bash
php artisan serve
```
Lalu buka alamat `http://127.0.0.1:8000` di Google Chrome Anda.

---

## Akun Login default
- **Admin**: `admin@example.com` / `password123`
- **User**: `user@example.com` / `password123`
