<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailPinjam;
use Illuminate\Http\Request;

class DetailPinjamController extends Controller
{
    public function index()
    {
        return response()->json(
            DetailPinjam::with([
                'peminjaman',
                'alat',
            ])->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peminjaman_id' => ['required', 'exists:peminjaman,id'],
            'alat_id' => ['required', 'exists:alat,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        return response()->json(DetailPinjam::create($data), 201);
    }

    public function show(DetailPinjam $detailPinjam)
    {
        return response()->json(
            $detailPinjam->load([
                'peminjaman',
                'alat',
            ])
        );
    }

    public function update(Request $request, DetailPinjam $detailPinjam)
    {
        $data = $request->validate([
            'peminjaman_id' => ['sometimes', 'exists:peminjaman,id'],
            'alat_id' => ['sometimes', 'exists:alat,id'],
            'jumlah' => ['sometimes', 'integer', 'min:1'],
        ]);

        $detailPinjam->update($data);

        return response()->json($detailPinjam);
    }

    public function destroy(DetailPinjam $detailPinjam)
    {
        $detailPinjam->delete();

        return response()->json([
            'message' => 'Detail peminjaman berhasil dihapus.',
        ]);
    }
}
