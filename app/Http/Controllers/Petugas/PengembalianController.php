<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'detailPinjams.alat'])
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        return view('petugas.pengembalian.index', compact('peminjamans'));
    }

    public function proses(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'kondisi_kembali' => 'required|string|max:100',
            'denda' => 'nullable|integer|min:0',
        ]);

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Peminjaman ini tidak sedang berjalan.');
        }

        DB::beginTransaction();
        try {
            $peminjaman->load('detailPinjams');

            $peminjaman->pengembalian()->create([
                'petugas_id' => auth()->id(),
                'tgl_kembali' => now(),
                'kondisi_kembali' => $validated['kondisi_kembali'],
                'denda' => $validated['denda'] ?? 0,
            ]);

            $peminjaman->update(['status' => 'selesai']);

            // Kembalikan stok alat ke inventaris
            foreach ($peminjaman->detailPinjams as $detail) {
                Alat::where('id', $detail->alat_id)->increment('stok', $detail->jumlah);
            }

            LogAktivitas::catat(auth()->id(), "Memproses pengembalian peminjaman #{$peminjaman->id}");

            DB::commit();

            return redirect()->route('petugas.pengembalian.index')
                ->with('success', 'Pengembalian berhasil dicatat dan stok dipulihkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
