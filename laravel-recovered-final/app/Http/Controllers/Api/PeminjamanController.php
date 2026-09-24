<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        return response()->json(
            Peminjaman::with([
                'user',
                'detailPinjam.alat',
                'pengembalian',
            ])->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'tgl_pinjam' => ['required', 'date'],
            'tgl_kembali_plan' => ['required', 'date', 'after_or_equal:tgl_pinjam'],
            'status' => ['nullable', 'in:diajukan,dipinjam,dikembalikan,telat'],
        ]);

        $data['status'] ??= 'diajukan';

        return response()->json(Peminjaman::create($data), 201);
    }

    public function show(Peminjaman $peminjaman)
    {
        return response()->json(
            $peminjaman->load([
                'user',
                'detailPinjam.alat',
                'pengembalian',
            ])
        );
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $data = $request->validate([
            'user_id' => ['sometimes', 'exists:users,id'],
            'tgl_pinjam' => ['sometimes', 'date'],
            'tgl_kembali_plan' => ['sometimes', 'date'],
            'status' => ['sometimes', 'in:diajukan,dipinjam,dikembalikan,telat'],
        ]);

        $peminjaman->update($data);

        return response()->json($peminjaman);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return response()->json([
            'message' => 'Peminjaman berhasil dihapus.',
        ]);
    }
}
