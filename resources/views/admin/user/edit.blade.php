@extends('layouts.app')

@section('title', 'Edit User - Panel Admin')
@section('header-title', 'Edit Data Pengguna')

@section('content')

<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Form Edit User</h3></div>
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Password Baru <span class="text-muted">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label>Role / Hak Akses</label>
                <select name="role" class="form-control" required>
                    <option value="peminjam" {{ $user->role == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="form-control">
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mr-2">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
</div>

@endsection
