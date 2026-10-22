<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $fillable = [
        'kategori_id',
        'nama_alat',
        'stok',
        'status_kondisi',
        'deskripsi',
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function detailPinjams()
    {
        return $this->hasMany(DetailPinjam::class);
    }
}
