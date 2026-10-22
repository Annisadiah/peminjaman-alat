@extends('layouts.app')

@section('title', 'Edit Kategori - Panel Admin')
@section('header-title', 'Edit Kategori Alat')

@section('content')

<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Form Edit Kategori</h3></div>
    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                       class="form-control @error('nama_kategori') is-invalid @enderror" required>
                @error('nama_kategori') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary mr-2">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
</div>

@endsection
