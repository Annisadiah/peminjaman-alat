<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'detailPinjams.alat'])
            ->latest()
            ->get();

        return view('petugas.peminjaman.index', compact('peminjamans'));
    }

    public function setujui(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'diajukan') {
            return redirect()->back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        DB::beginTransaction();
        try {
            $peminjaman->load('detailPinjams');

            foreach ($peminjaman->detailPinjams as $detail) {
                $alat = Alat::findOrFail($detail->alat_id);

                if ($alat->stok < $detail->jumlah) {
                    throw new \Exception("Stok {$alat->nama_alat} tidak mencukupi.");
                }

                $alat->decrement('stok', $detail->jumlah);
            }

            $peminjaman->update(['status' => 'dipinjam']);

            LogAktivitas::catat(auth()->id(), "Menyetujui peminjaman #{$peminjaman->id}");

            DB::commit();

            return redirect()->back()->with('success', 'Peminjaman disetujui dan stok alat dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
