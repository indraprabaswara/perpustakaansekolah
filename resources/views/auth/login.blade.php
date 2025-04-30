<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .parallax {
            perspective: 1000px;
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen overflow-hidden relative">
    <div class="parallax absolute inset-0 flex items-center justify-center">
        <div class="absolute w-32 h-32 bg-blue-500 rounded-full opacity-30 floating" style="top: 10%; left: 20%;"></div>
        <div class="absolute w-24 h-24 bg-purple-500 rounded-full opacity-30 floating" style="top: 60%; left: 80%; animation-delay: 2s;"></div>
        <div class="absolute w-40 h-40 bg-green-500 rounded-full opacity-30 floating" style="top: 80%; left: 30%; animation-delay: 4s;"></div>
    </div>
    
    <div class="relative bg-white p-8 rounded-2xl shadow-lg w-full max-w-md z-10">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-4">Login Perpustakaan</h2>
        
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700">Username</label>
                <input type="text" name="username" class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-400" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-400" required>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg font-semibold hover:bg-blue-700 transition">Masuk</button>
        </form>
        
        <div class="text-center mt-4">
            <p class="text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 font-semibold">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>
