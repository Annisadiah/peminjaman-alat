@extends('layouts.app')

@section('title', 'Kelola Peminjaman - Panel Admin')
@section('header-title', 'Manajemen Transaksi Peminjaman')

@section('content')

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <h3 class="card-title mb-2 mb-md-0">Daftar Transaksi Peminjaman</h3>

        <div class="d-flex flex-wrap align-items-center">
            <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="form-inline mr-2 mb-2 mb-md-0">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm mr-1" placeholder="Cari nama peminjam / status...">
                <button type="submit" class="btn btn-sm btn-secondary mr-1"><i class="fas fa-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset"><i class="fas fa-times"></i></a>
                @endif
            </form>
            <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-sm btn-primary mb-2 mb-md-0">
                <i class="fas fa-plus"></i> Tambah Peminjaman
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap mb-0">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Alat yang Dipinjam</th>
                    <th>Tgl Pinjam / Rencana Kembali</th>
                    <th>Status</th>
                    <th style="width:180px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjaman->user->name ?? 'User Dihapus' }}</td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($peminjaman->detailPinjams as $detail)
                                    <li>{{ $detail->alat->nama_alat ?? 'Alat Dihapus' }}
                                        <span class="badge badge-light">{{ $detail->jumlah }} pcs</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-sm">
                            Pinjam: {{ $peminjaman->tgl_pinjam }}<br>
                            Rencana: {{ $peminjaman->tgl_kembali_plan }}
                        </td>
                        <td>
                            <span class="badge
                                @if($peminjaman->status == 'diajukan') badge-warning
                                @elseif($peminjaman->status == 'dipinjam') badge-info
                                @elseif($peminjaman->status == 'selesai') badge-success
                                @else badge-danger @endif">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.peminjaman.updateStatus', $peminjaman->id) }}" method="POST" class="mb-1">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="form-control form-control-sm">
                                    <option value="diajukan" {{ $peminjaman->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                    <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                    <option value="selesai" {{ $peminjaman->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="telat" {{ $peminjaman->status == 'telat' ? 'selected' : '' }}>Telat</option>
                                </select>
                            </form>
                            <form action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger btn-block">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-3">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $peminjamans->links() }}
    </div>
</div>

@endsection
