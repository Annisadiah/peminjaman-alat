@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header-title', 'Ringkasan Aktivitas Sistem')

@section('content')

<div class="callout callout-info">
    Selamat datang, <strong>{{ auth()->user()->name }}</strong>! Anda login sebagai
    <span class="badge badge-info text-uppercase">{{ auth()->user()->role }}</span>.
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Log Aktivitas Terbaru</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->user->name ?? 'Sistem' }}</td>
                        <td>{{ $log->aktivitas }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-3">Belum ada aktivitas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
