<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class RiwayatController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('detailPinjams.alat')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peminjam.riwayat', compact('peminjamans'));
    }
}
