@extends('layouts.app')

@section('title', 'Kelola User - Panel Admin')
@section('header-title', 'Manajemen Pengguna Sistem')

@section('content')

<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
        <h3 class="card-title mb-2 mb-md-0">Daftar Pengguna Sistem</h3>

        <div class="d-flex flex-wrap align-items-center">
            <form action="{{ route('admin.user.index') }}" method="GET" class="form-inline mr-2 mb-2 mb-md-0">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm mr-1" placeholder="Cari nama, email, role...">
                <button type="submit" class="btn btn-sm btn-secondary mr-1"><i class="fas fa-search"></i></button>
                @if(request('search'))
                    <a href="{{ route('admin.user.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset"><i class="fas fa-times"></i></a>
                @endif
            </form>
            <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-primary mb-2 mb-md-0">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role / Hak Akses</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge
                                @if($user->role == 'admin') badge-primary
                                @elseif($user->role == 'petugas') badge-info
                                @else badge-success @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->no_hp ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-xs btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                        <td colspan="5" class="text-center py-3">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>

@endsection
