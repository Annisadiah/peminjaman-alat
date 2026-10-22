<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $alats = Alat::with('kategori')
            ->when($request->search, function ($query, $search) {
                $query->where('nama_alat', 'like', "%{$search}%")
                    ->orWhereHas('kategori', fn ($q) => $q->where('nama_kategori', 'like', "%{$search}%"));
            })
            ->orderBy('nama_alat')
            ->paginate(10)
            ->withQueryString();

        return view('admin.alat.index', compact('alats'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_alat' => 'required|string|max:150',
            'stok' => 'required|integer|min:0',
            'status_kondisi' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        $alat = Alat::create($validated);

        LogAktivitas::catat(auth()->id(), 'Menambahkan alat baru: ' . $alat->nama_alat);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_alat' => 'required|string|max:150',
            'stok' => 'required|integer|min:0',
            'status_kondisi' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        $alat->update($validated);

        LogAktivitas::catat(auth()->id(), 'Memperbarui data alat: ' . $alat->nama_alat);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Alat $alat)
    {
        if ($alat->detailPinjams()->exists()) {
            return redirect()->route('admin.alat.index')
                ->with('error', 'Alat tidak bisa dihapus karena memiliki riwayat peminjaman.');
        }

        if ($alat->gambar) {
            Storage::disk('public')->delete($alat->gambar);
        }

        $nama = $alat->nama_alat;
        $alat->delete();

        LogAktivitas::catat(auth()->id(), 'Menghapus alat: ' . $nama);

        return redirect()->route('admin.alat.index')->with('success', 'Alat berhasil dihapus.');
    }
}
