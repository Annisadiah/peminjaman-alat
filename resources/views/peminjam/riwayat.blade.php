@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - Peminjam')
@section('header-title', 'Riwayat Peminjaman Saya')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Peminjaman</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap mb-0">
            <thead>
                <tr>
                    <th>Alat yang Dipinjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Rencana Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                    <tr>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @foreach($peminjaman->detailPinjams as $detail)
                                    <li>{{ $detail->alat->nama_alat ?? '-' }}
                                        <span class="badge badge-light">{{ $detail->jumlah }} pcs</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $peminjaman->tgl_pinjam }}</td>
                        <td>{{ $peminjaman->tgl_kembali_plan }}</td>
                        <td>
                            <span class="badge
                                @if($peminjaman->status == 'diajukan') badge-warning
                                @elseif($peminjaman->status == 'dipinjam') badge-info
                                @elseif($peminjaman->status == 'selesai') badge-success
                                @else badge-danger @endif">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-3">Anda belum pernah meminjam alat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
