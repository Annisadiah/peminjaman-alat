<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-gray-900 text-white flex flex-col hidden md:flex">
            <div class="p-5 text-xl font-bold tracking-wider border-b border-gray-800">
                PANEL ADMIN
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2 rounded-lg bg-gray-800 text-white font-medium">
                   Dashboard
                </a>
                <a href="{{ route('admin.user.index') }}"
                   class="block px-4 py-2 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition">
                   Kelola User
                </a>
                <a href="{{ route('admin.kategori.index') }}"
                   class="block px-4 py-2 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition">
                   Kelola Kategori
                </a>
                <a href="{{ route('admin.alat.index') }}"
                   class="block px-4 py-2 rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition">
                   Kelola Alat
                </a>
            </nav>
            <div class="p-4 border-t border-gray-800 text-sm text-gray-400">
                Masuk sebagai: <span class="text-white font-semibold">{{ auth()->user()->name }}</span>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
                <h1 class="text-lg font-semibold text-gray-800">
                    @yield('header-title', 'Dashboard')
                </h1>
                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-6">
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
