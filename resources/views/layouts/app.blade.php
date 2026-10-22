<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peminjaman Alat')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- NAVBAR --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link">@yield('header-title', 'Dashboard')</span>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">
                    <i class="fas fa-user mr-1"></i>{{ auth()->user()->name }}
                    <span class="badge badge-secondary">{{ ucfirst(auth()->user()->role) }}</span>
                </span>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="form-inline">
                    @csrf
                    <button type="submit" class="btn btn-tool nav-link" style="border:none;background:none;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    {{-- SIDEBAR --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <i class="fas fa-boxes brand-image ml-2"></i>
            <span class="brand-text font-weight-light">Sistem Peminjaman</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i><p>Kelola User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tags"></i><p>Kelola Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.alat.index') }}" class="nav-link {{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-toolbox"></i><p>Kelola Alat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.peminjaman.index') }}" class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-list"></i><p>Kelola Peminjaman</p>
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'petugas')
                        <li class="nav-item">
                            <a href="{{ route('petugas.peminjaman.index') }}" class="nav-link {{ request()->routeIs('petugas.peminjaman.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-clipboard-check"></i><p>Persetujuan Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('petugas.pengembalian.index') }}" class="nav-link {{ request()->routeIs('petugas.pengembalian.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-undo-alt"></i><p>Pengembalian Alat</p>
                            </a>
                        </li>
                    @elseif(auth()->user()->role === 'peminjam')
                        <li class="nav-item">
                            <a href="{{ route('peminjam.katalog') }}" class="nav-link {{ request()->routeIs('peminjam.katalog') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th-list"></i><p>Katalog Alat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('peminjam.riwayat') }}" class="nav-link {{ request()->routeIs('peminjam.riwayat') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-history"></i><p>Riwayat Peminjaman</p>
                            </a>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    </aside>

    {{-- CONTENT --}}
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>@yield('header-title', 'Dashboard')</h1></div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')

            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>&copy; {{ date('Y') }} Sistem Peminjaman Alat.</strong> All rights reserved.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>
