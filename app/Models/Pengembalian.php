<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'petugas_id',
        'tgl_kembali',
        'kondisi_kembali',
        'denda',
    ];

    protected function casts(): array
    {
        return [
            'tgl_kembali' => 'datetime',
        ];
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
