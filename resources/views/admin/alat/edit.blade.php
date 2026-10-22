@extends('layouts.app')

@section('title', 'Edit Alat - Panel Admin')
@section('header-title', 'Edit Data Alat')

@section('content')

<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Form Edit Alat</h3></div>
    <form action="{{ route('admin.alat.update', $alat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="form-group">
                <label>Nama Alat</label>
                <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}"
                       class="form-control @error('nama_alat') is-invalid @enderror" required>
                @error('nama_alat') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $alat->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $alat->stok) }}" min="0"
                           class="form-control @error('stok') is-invalid @enderror" required>
                    @error('stok') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label>Status Kondisi</label>
                    <input type="text" name="status_kondisi" value="{{ old('status_kondisi', $alat->status_kondisi) }}"
                           class="form-control @error('status_kondisi') is-invalid @enderror" required>
                    @error('status_kondisi') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                @error('deskripsi') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Gambar Alat <span class="text-muted">(biarkan kosong jika tidak ingin mengubah gambar)</span></label>
                @if($alat->gambar)
                    <div class="mb-2">
                        <img src="{{ Storage::url($alat->gambar) }}" alt="Preview" style="width:80px;height:80px;object-fit:cover;border-radius:6px;">
                    </div>
                @endif
                <div class="custom-file">
                    <input type="file" name="gambar" accept="image/*" class="custom-file-input @error('gambar') is-invalid @enderror" id="gambarInput">
                    <label class="custom-file-label" for="gambarInput">Pilih file...</label>
                </div>
                @error('gambar') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.alat.index') }}" class="btn btn-secondary mr-2">Batal</a>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    $('.custom-file-input').on('change', function () {
        let fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName || 'Pilih file...');
    });
</script>
@endpush
