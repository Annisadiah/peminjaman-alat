<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::query()
            ->when($request->search, fn ($q, $search) => $q->where('nama_kategori', 'like', "%{$search}%"))
            ->orderBy('nama_kategori')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori',
        ]);

        $kategori = Kategori::create($validated);

        LogAktivitas::catat(auth()->id(), 'Menambahkan kategori baru: ' . $kategori->nama_kategori);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100', Rule::unique('kategoris', 'nama_kategori')->ignore($kategori->id)],
        ]);

        $kategori->update($validated);

        LogAktivitas::catat(auth()->id(), 'Memperbarui kategori: ' . $kategori->nama_kategori);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->alats()->exists()) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh alat.');
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        LogAktivitas::catat(auth()->id(), 'Menghapus kategori: ' . $nama);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
