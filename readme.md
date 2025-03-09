# Proyek Laravel 8 dan vue dengan MYSQL Work Order

Proyek ini adalah Sistem Manajemen Work Order untuk Manufaktur yang menggunakan Laravel 8 sebagai backend dan Vue dengan Vuetify v2 sebagai frontend. Aplikasi ini terhubung ke database Mysql.

## Prerequisites

Sebelum memulai, pastikan Anda telah menginstal:

- PHP 7.6 keatas 
- Composer
- Node.js dan npm
- MYSQL

## Langkah-langkah Instalasi

1. **Restore Database MYSQL**
   - Pastikan Anda telah mengembalikan database MYSQL yang diperlukan. Database dapat ditemukan di folder `database`.

2. **Konfigurasi Environment**
   - Buka terminal dan navigasikan ke folder proyek.
   - Salin file `.env.example` menjadi `.env`:
     ```bash
     cp .env.example .env
     ```
   - Edit file `.env` dan masukkan konfigurasi MYSQL Anda:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=5432
     DB_DATABASE=nama_database
     DB_USERNAME=nama_pengguna
     DB_PASSWORD=kata_sandi
     ```

3. **Instalasi Dependensi Backend**
   - Jalankan perintah berikut untuk menginstal dependensi PHP:
     ```bash
     composer install
     ```


4. **Menjalankan Backend**
   - Jalankan server Laravel:
     ```bash
     php artisan serve
     ```
   - Backend akan berjalan di `http://localhost:8000`.

. **Migrasi Database apabila tidak ingin restore**
   - Jalankan migrasi untuk membuat tabel di database:
     ```bash
     php artisan migrate
     ```

     
## Menjalankan Frontend

1. **Navigasi ke Folder Frontend**
   - Masuk ke folder frontend:
     ```bash
     cd frontend
     ```

2. **Instalasi Dependensi Frontend**
   - Jalankan perintah berikut untuk menginstal dependensi Node.js:
     ```bash
     npm install
     ```

3. **Menjalankan Frontend**
   - Jalankan perintah berikut untuk memulai server pengembangan vue:
     ```bash
     npm run serve
     ```
   - Frontend akan berjalan di `http://localhost:8080`.

## Teknologi yang Digunakan

- **Backend**: Laravel
- **Frontend**: vue, Vuetify
- **Database**: MYSQL

## Login 
. **Manager**
```bash
username : Manager
Password : 123456
```
. **Operator**
```bash
username : Operator 1
Password : 123456
```