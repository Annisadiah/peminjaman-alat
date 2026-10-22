@extends('layouts.app')

@section('title', 'Kelola Alat - Panel Admin')
@section('header-title', 'Manajemen Data Alat')

@section('content')

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <h3 class="card-title mb-2 mb-md-0">Daftar Alat Laboratorium</h3>

        <div class="d-flex flex-wrap align-items-center">
            <form action="{{ route('admin.alat.index') }}" method="GET" class="form-inline mr-2 mb-2 mb-md-0">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm mr-1" placeholder="Cari nama alat, kategori...">
                <button type="submit" class="btn btn-sm btn-secondary mr-1"><i class="fas fa-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('admin.alat.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset"><i class="fas fa-times"></i></a>
                @endif
            </form>
            <a href="{{ route('admin.alat.create') }}" class="btn btn-sm btn-primary mb-2 mb-md-0">
                <i class="fas fa-plus"></i> Tambah Alat
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap mb-0">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Alat</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alats as $alat)
                    <tr>
                        <td>
                            @if($alat->gambar)
                                <img src="{{ Storage::url($alat->gambar) }}" alt="{{ $alat->nama_alat }}" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                            @else
                                <span class="text-muted font-italic small">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $alat->nama_alat }}</td>
                        <td>{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                        <td><strong>{{ $alat->stok }}</strong></td>
                        <td>
                            <span class="badge {{ strtolower($alat->status_kondisi) == 'baik' ? 'badge-success' : 'badge-warning' }}">
                                {{ $alat->status_kondisi }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.alat.edit', $alat->id) }}" class="btn btn-xs btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">Belum ada data alat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $alats->links() }}
    </div>
</div>

@endsection
