<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(Kategori::with('alat')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
        ]);

        return response()->json(Kategori::create($data), 201);
    }

    public function show(Kategori $kategori)
    {
        return response()->json($kategori->load('alat'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255'],
        ]);

        $kategori->update($data);

        return response()->json($kategori);
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus.',
        ]);
    }
}
