@extends('layouts.app')

@section('title', 'Tambah User - Panel Admin')
@section('header-title', 'Tambah Pengguna Baru')

@section('content')

<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Form Tambah User</h3></div>
    <form action="{{ route('admin.user.store') }}" method="POST">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Role / Hak Akses</label>
                <select name="role" class="form-control" required>
                    <option value="peminjam">Peminjam</option>
                    <option value="petugas">Petugas</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label>No. HP (Opsional)</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control">
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mr-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

@endsection
