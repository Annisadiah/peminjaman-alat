<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        return response()->json(
            Pengembalian::with([
                'peminjaman',
                'petugas',
            ])->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'peminjaman_id' => ['required', 'exists:peminjaman,id'],
            'tgl_kembali' => ['required', 'date'],
            'kondisi_kembali' => ['required', 'string', 'max:255'],
            'denda' => ['nullable', 'integer', 'min:0'],
            'petugas_id' => ['required', 'exists:users,id'],
        ]);

        $data['denda'] ??= 0;

        $pengembalian = Pengembalian::create($data);

        return response()->json($pengembalian, 201);
    }

    public function show(Pengembalian $pengembalian)
    {
        return response()->json(
            $pengembalian->load([
                'peminjaman',
                'petugas',
            ])
        );
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $data = $request->validate([
            'peminjaman_id' => ['sometimes', 'exists:peminjaman,id'],
            'tgl_kembali' => ['sometimes', 'date'],
            'kondisi_kembali' => ['sometimes', 'string', 'max:255'],
            'denda' => ['sometimes', 'integer', 'min:0'],
            'petugas_id' => ['sometimes', 'exists:users,id'],
        ]);

        $pengembalian->update($data);

        return response()->json($pengembalian);
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();

        return response()->json([
            'message' => 'Pengembalian berhasil dihapus.',
        ]);
    }
}
