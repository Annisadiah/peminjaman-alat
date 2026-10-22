<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailPinjam;
use App\Models\Peminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'detailPinjams.alat'])->latest();

        if ($request->user()->role === 'peminjam') {
            $query->where('user_id', $request->user()->id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_kembali_plan' => 'required|date|after:today',
            'alat_id' => 'required|array',
            'alat_id.*' => 'exists:alats,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'user_id' => $request->user()->id,
                'tgl_pinjam' => now(),
                'tgl_kembali_plan' => $request->tgl_kembali_plan,
                'status' => 'diajukan',
            ]);

            foreach ($request->alat_id as $i => $alatId) {
                $alat = Alat::findOrFail($alatId);
                if ($alat->stok < $request->jumlah[$i]) {
                    throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi.");
                }
                DetailPinjam::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $alatId,
                    'jumlah' => $request->jumlah[$i],
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Peminjaman berhasil diajukan',
                'data' => $peminjaman->load('detailPinjams.alat'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:diajukan,dipinjam,selesai,telat']);

        $peminjaman = Peminjaman::with('detailPinjams.alat')->findOrFail($id);

        DB::beginTransaction();
        try {
            $lama = $peminjaman->status;
            $baru = $request->status;

            if ($lama != 'dipinjam' && $baru == 'dipinjam') {
                foreach ($peminjaman->detailPinjams as $d) {
                    if ($d->alat->stok < $d->jumlah) {
                        throw new \Exception("Stok {$d->alat->nama_alat} tidak mencukupi.");
                    }
                    $d->alat->decrement('stok', $d->jumlah);
                }
            } elseif ($lama == 'dipinjam' && $baru == 'selesai') {
                foreach ($peminjaman->detailPinjams as $d) {
                    $d->alat->increment('stok', $d->jumlah);
                }
            }

            $peminjaman->update(['status' => $baru]);
            DB::commit();
            return response()->json(['message' => 'Status berhasil diperbarui', 'data' => $peminjaman]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}