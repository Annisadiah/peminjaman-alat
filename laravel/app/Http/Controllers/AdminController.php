<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
        public function index()
    {
        $totalAlat = Alat::count();
        $totalUser = User::count();
        $peminjamanAktif = \App\Models\Peminjaman::whereIn('status', ['diajukan', 'dipinjam'])->count();
        $peminjamanTelat = \App\Models\Peminjaman::where('status', 'telat')->count();

        return view('admin.dashboard', compact('totalAlat', 'totalUser', 'peminjamanAktif', 'peminjamanTelat'));
    }
    public function indexAlat(Request $request)
    {
        $search = $request->input('search');

        $alats = Alat::with('kategori')
            ->when($search, function ($query, $search) {
                $query->where('nama_alat', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.alat.index', compact('alats', 'search'));
    }

    public function indexUser(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.user.index', compact('users', 'search'));
    }

    public function createAlat()
    {
        $kategoris = Kategori::all();
        return view('admin.alat.create', compact('kategoris'));
    }

    public function storeAlat(Request $request)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('alat', 'public');
        }

        $alat = Alat::create([
            'nama_alat'   => $request->nama_alat,
            'kategori_id' => $request->kategori_id,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'foto'        => $fotoPath,
        ]);

        LogAktivitas::create([
            'user_id'   => auth()->id(),
            'aktivitas' => "Menambahkan alat baru: {$alat->nama_alat}",
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil ditambahkan!');
    }

    public function editAlat($id)
    {
        $alat = Alat::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.alat.edit', compact('alat', 'kategoris'));
    }

    public function updateAlat(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $fotoPath = $alat->foto;
        if ($request->hasFile('foto')) {
            if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
                Storage::disk('public')->delete($alat->foto);
            }
            $fotoPath = $request->file('foto')->store('alat', 'public');
        }

        $alat->update([
            'nama_alat'   => $request->nama_alat,
            'kategori_id' => $request->kategori_id,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'foto'        => $fotoPath,
        ]);

        LogAktivitas::create([
            'user_id'   => auth()->id(),
            'aktivitas' => "Mengubah data alat: {$alat->nama_alat}",
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    public function destroyAlat($id)
    {
        $alat = Alat::findOrFail($id);

        if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
            Storage::disk('public')->delete($alat->foto);
        }

        $namaAlat = $alat->nama_alat;
        $alat->delete();

        LogAktivitas::create([
            'user_id'   => auth()->id(),
            'aktivitas' => "Menghapus alat: {$namaAlat}",
        ]);

        return redirect()->route('admin.alat.index')->with('success', 'Data alat berhasil dihapus!');
    }
}