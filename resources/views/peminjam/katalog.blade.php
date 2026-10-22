@extends('layouts.app')

@section('title', 'Katalog Alat - Peminjam')
@section('header-title', 'Katalog Alat Tersedia')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ajukan Peminjaman Alat</h3>
    </div>
    <form action="{{ route('peminjam.peminjaman.ajukan') }}" method="POST">
        @csrf
        <div class="card-body">

            <div class="form-group col-md-4 px-0">
                <label>Rencana Tanggal Kembali</label>
                <input type="date" name="tgl_kembali_plan" class="form-control" required>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:50px">Pilih</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok Tersedia</th>
                        <th style="width:150px">Jumlah Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alats as $alat)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="alat_id[]" value="{{ $alat->id }}" class="form-check-input">
                            </td>
                            <td>{{ $alat->nama_alat }}</td>
                            <td>{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $alat->stok }}</td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control form-control-sm" value="1" min="1" max="{{ $alat->stok }}">
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Tidak ada alat yang tersedia saat ini.</td></tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Ajukan Peminjaman</button>
        </div>
    </form>
</div>

@endsection
