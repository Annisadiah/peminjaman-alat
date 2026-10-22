# Web Peminjaman Alat

Aplikasi web peminjaman alat berbasis Laravel.

## Cara Menjalankan

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Atur koneksi database di file `.env`, lalu buat database kosong di MySQL. Setelah itu:

```bash
php artisan migrate --seed
npm run build
php artisan serve
```

Buka http://127.0.0.1:8000

## Akun Login

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sekolah.sch.id | password |
| Petugas | petugas@sekolah.sch.id | password |
| Peminjam | peminjam@sekolah.sch.id | password |
