<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    public function index()
    {
        $alats = Alat::with('kategori')->where('stok', '>', 0)->orderBy('nama_alat')->get();

        return view('peminjam.katalog', compact('alats'));
    }

    public function ajukan(Request $request)
    {
        $validated = $request->validate([
            'tgl_kembali_plan' => 'required|date|after_or_equal:today',
            'alat_id' => 'required|array|min:1',
            'alat_id.*' => 'required|exists:alats,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'user_id' => auth()->id(),
                'tgl_pinjam' => now()->toDateString(),
                'tgl_kembali_plan' => $validated['tgl_kembali_plan'],
                'status' => 'diajukan',
            ]);

            foreach ($validated['alat_id'] as $index => $alatId) {
                $jumlah = $validated['jumlah'][$index];
                $alat = Alat::findOrFail($alatId);

                if ($alat->stok < $jumlah) {
                    throw new \Exception("Stok {$alat->nama_alat} tidak mencukupi.");
                }

                $peminjaman->detailPinjams()->create([
                    'alat_id' => $alatId,
                    'jumlah' => $jumlah,
                ]);
            }

            LogAktivitas::catat(auth()->id(), auth()->user()->name . ' mengajukan peminjaman baru');

            DB::commit();

            return redirect()->route('peminjam.riwayat')->with('success', 'Pengajuan peminjaman berhasil dikirim, menunggu persetujuan petugas.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Gagal mengajukan: ' . $e->getMessage());
        }
    }
}
