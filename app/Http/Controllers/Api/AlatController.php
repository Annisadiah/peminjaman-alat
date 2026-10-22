<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        return response()->json(Alat::with('kategori')->get());
    }

    public function show($id)
    {
        return response()->json(Alat::with('kategori')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_alat' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'status_kondisi' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $alat = Alat::create($data);
        return response()->json(['message' => 'Alat berhasil ditambahkan', 'data' => $alat], 201);
    }

    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $data = $request->validate([
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'nama_alat' => 'sometimes|string|max:255',
            'stok' => 'sometimes|integer|min:0',
            'status_kondisi' => 'sometimes|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $alat->update($data);
        return response()->json(['message' => 'Alat berhasil diperbarui', 'data' => $alat]);
    }

    public function destroy($id)
    {
        Alat::findOrFail($id)->delete();
        return response()->json(['message' => 'Alat berhasil dihapus']);
    }
}