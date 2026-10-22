# Web Peminjaman Alat

Aplikasi web peminjaman alat berbasis Laravel.

## Cara Menjalankan

1. Install dependency
   composer install
   npm install

2. Siapkan environment
   copy .env.example .env
   php artisan key:generate

3. Atur koneksi database di file .env, lalu buat database kosong di MySQL.

4. Migrasi dan isi data awal
   php artisan migrate --seed

5. Jalankan
   npm run build
   php artisan serve

Buka http://127.0.0.1:8000

## Akun Login
- Petugas: petugas@sekolah.sch.id (isi password sesuai seeder)
