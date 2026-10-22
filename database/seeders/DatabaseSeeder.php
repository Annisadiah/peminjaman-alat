<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User default untuk tiap role
        User::create([
            'name' => 'Fajar Nugraha',
            'email' => 'admin@sekolah.sch.id',
            'password' => 'password',
            'role' => 'admin',
            'no_hp' => '081234567891',
        ]);

        User::create([
            'name' => 'Rina Marlina',
            'email' => 'petugas@sekolah.sch.id',
            'password' => 'password',
            'role' => 'petugas',
            'no_hp' => '081322110098',
        ]);

        User::create([
            'name' => 'Ahmad Fauzan',
            'email' => 'peminjam@sekolah.sch.id',
            'password' =>'password',
            'role' => 'peminjam',
            'no_hp' => '085799001122',
        ]);

        // Kategori
        $kategoris = ['Elektronik & Multimedia', 'Alat Olahraga', 'Alat Musik', 'Alat Laboratorium', 'Perkakas Bengkel'];
        foreach ($kategoris as $nama) {
            Kategori::create(['nama_kategori' => $nama]);
        }

        // Alat contoh
        Alat::create(['kategori_id' => 1, 'nama_alat' => 'Proyektor Epson EB-X400', 'stok' => 4, 'status_kondisi' => 'Baik']);
        Alat::create(['kategori_id' => 4, 'nama_alat' => 'Multimeter Digital Sanwa', 'stok' => 12, 'status_kondisi' => 'Baik']);
        Alat::create(['kategori_id' => 2, 'nama_alat' => 'Bola Basket Molten GG7', 'stok' => 8, 'status_kondisi' => 'Rusak Ringan']);
        Alat::create(['kategori_id' => 3, 'nama_alat' => 'Gitar Akustik Yamaha F310', 'stok' => 3, 'status_kondisi' => 'Baik']);
        Alat::create(['kategori_id' => 4, 'nama_alat' => 'Mikroskop Binokuler', 'stok' => 6, 'status_kondisi' => 'Baik']);
        Alat::create(['kategori_id' => 5, 'nama_alat' => 'Bor Listrik Bosch GSB 13RE', 'stok' => 5, 'status_kondisi' => 'Baik']);
    }
}
