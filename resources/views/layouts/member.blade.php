<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Peminjaman buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold">Peminjaman Buku</h1>
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('member.dashboard') }}" class="hover:text-gray-300 transition">Dashboard</a>
                        <a href="{{ route('member.borrow.index') }}" class="hover:text-gray-300 transition">Peminjaman</a>
                        <a href="{{ route('member.return.index') }}" class="hover:text-gray-300 transition">Pengembalian</a>
                    </div>
                </div>
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-white text-blue-600 px-4 py-2 rounded-md font-medium hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-10 max-w-6xl mx-auto px-6">
        @yield('content')
    </main>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-md shadow-md transition-opacity duration-300">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-600 text-white px-6 py-3 rounded-md shadow-md transition-opacity duration-300">
        {{ session('error') }}
    </div>
    @endif
</body>
</html>
