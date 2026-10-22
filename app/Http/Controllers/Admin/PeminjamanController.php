<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $peminjamans = Peminjaman::with(['user', 'detailPinjams.alat'])
            ->when($request->search, function ($query, $search) {
                $query->where('status', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::where('role', 'peminjam')->orderBy('name')->get();
        $alats = Alat::where('stok', '>', 0)->orderBy('nama_alat')->get();

        return view('admin.peminjaman.create', compact('users', 'alats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_plan' => 'required|date|after_or_equal:tgl_pinjam',
            'alat_id' => 'required|array|min:1',
            'alat_id.*' => 'required|exists:alats,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'user_id' => $validated['user_id'],
                'tgl_pinjam' => $validated['tgl_pinjam'],
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

            LogAktivitas::catat(auth()->id(), 'Menambahkan peminjaman baru untuk user #' . $validated['user_id']);

            DB::commit();

            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'status' => 'required|in:diajukan,dipinjam,selesai,telat',
        ]);

        DB::beginTransaction();
        try {
            $statusLama = $peminjaman->status;

            // Jika baru disetujui jadi "dipinjam", kurangi stok alat
            if ($statusLama !== 'dipinjam' && $validated['status'] === 'dipinjam') {
                foreach ($peminjaman->detailPinjams as $detail) {
                    $alat = Alat::findOrFail($detail->alat_id);
                    if ($alat->stok < $detail->jumlah) {
                        throw new \Exception("Stok {$alat->nama_alat} tidak mencukupi.");
                    }
                    $alat->decrement('stok', $detail->jumlah);
                }
            }

            // Jika sebelumnya dipinjam lalu dibatalkan/diajukan ulang, kembalikan stok
            if ($statusLama === 'dipinjam' && $validated['status'] !== 'dipinjam' && $validated['status'] !== 'selesai') {
                foreach ($peminjaman->detailPinjams as $detail) {
                    Alat::where('id', $detail->alat_id)->increment('stok', $detail->jumlah);
                }
            }

            $peminjaman->update(['status' => $validated['status']]);

            LogAktivitas::catat(auth()->id(), "Mengubah status peminjaman #{$peminjaman->id} menjadi {$validated['status']}");

            DB::commit();

            return redirect()->route('admin.peminjaman.index')->with('success', 'Status peminjaman berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $e->getMessage());
        }
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok jika statusnya masih "dipinjam"
            if ($peminjaman->status === 'dipinjam') {
                foreach ($peminjaman->detailPinjams as $detail) {
                    Alat::where('id', $detail->alat_id)->increment('stok', $detail->jumlah);
                }
            }

            $peminjaman->delete();

            LogAktivitas::catat(auth()->id(), "Menghapus data peminjaman #{$peminjaman->id}");

            DB::commit();

            return redirect()->route('admin.peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
