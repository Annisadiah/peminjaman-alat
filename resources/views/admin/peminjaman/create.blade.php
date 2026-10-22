@extends('layouts.app')

@section('title', 'Tambah Peminjaman - Panel Admin')
@section('header-title', 'Form Tambah Transaksi Peminjaman')

@section('content')

<div class="card card-primary">
    <div class="card-header"><h3 class="card-title">Form Tambah Peminjaman</h3></div>
    <form action="{{ route('admin.peminjaman.store') }}" method="POST">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label>Pilih Peminjam (User)</label>
                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam" value="{{ old('tgl_pinjam', date('Y-m-d')) }}"
                           class="form-control @error('tgl_pinjam') is-invalid @enderror" required>
                    @error('tgl_pinjam') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label>Rencana Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali_plan" value="{{ old('tgl_kembali_plan', date('Y-m-d', strtotime('+3 days'))) }}"
                           class="form-control @error('tgl_kembali_plan') is-invalid @enderror" required>
                    @error('tgl_kembali_plan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Daftar Alat yang Dipinjam</label>
                <div id="alat-container">
                    <div class="form-row alat-row mb-2">
                        <div class="col-7">
                            <select name="alat_id[]" required class="form-control">
                                <option value="">-- Pilih Alat --</option>
                                @foreach($alats as $alat)
                                    <option value="{{ $alat->id }}">{{ $alat->nama_alat }} (Stok: {{ $alat->stok }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="number" name="jumlah[]" value="1" min="1" placeholder="Jumlah" class="form-control" required>
                        </div>
                        <div class="col-2">
                            <button type="button" onclick="removeRow(this)" class="btn btn-danger btn-block"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addRow()" class="btn btn-sm btn-outline-secondary mt-1">
                    <i class="fas fa-plus"></i> Tambah Alat Lain
                </button>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary mr-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function addRow() {
        const container = document.getElementById('alat-container');
        const firstRow = container.querySelector('.alat-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('select').value = '';
        newRow.querySelector('input').value = '1';
        container.appendChild(newRow);
    }

    function removeRow(button) {
        const rows = document.querySelectorAll('.alat-row');
        if (rows.length > 1) {
            button.closest('.alat-row').remove();
        } else {
            alert('Minimal harus ada 1 alat yang dipilih.');
        }
    }
</script>
@endpush
