<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        return response()->json(
            Alat::with('kategori')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => ['required', 'exists:kategori,id'],
            'nama_alat' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'status_kondisi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'string', 'max:255'],
        ]);

        return response()->json(Alat::create($data), 201);
    }

    public function show(Alat $alat)
    {
        return response()->json($alat->load([
            'kategori',
            'detailPinjam',
        ]));
    }

    public function update(Request $request, Alat $alat)
    {
        $data = $request->validate([
            'kategori_id' => ['sometimes', 'exists:kategori,id'],
            'nama_alat' => ['sometimes', 'string', 'max:255'],
            'stok' => ['sometimes', 'integer', 'min:0'],
            'status_kondisi' => ['sometimes', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'gambar' => ['nullable', 'string', 'max:255'],
        ]);

        $alat->update($data);

        return response()->json($alat);
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();

        return response()->json([
            'message' => 'Alat berhasil dihapus.',
        ]);
    }
}
