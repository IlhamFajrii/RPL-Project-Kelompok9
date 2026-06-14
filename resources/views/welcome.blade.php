<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPAL - Sistem Peminjaman Alat Laboratorium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 min-h-screen flex items-center justify-center px-4">
    <div class="text-center text-white max-w-2xl">
        @auth
            <script>window.location.href = "{{ route('dashboard') }}"</script>
        @else
            <h1 class="text-5xl font-bold mb-4">SPAL</h1>
            <p class="text-2xl mb-2">Sistem Peminjaman Alat Laboratorium</p>
            <p class="text-lg text-blue-200 mb-8">SMKN 2 Palembang</p>
            
            <div class="mt-12 flex gap-4 justify-center">
                <a href="{{ route('login') }}" class="px-8 py-3 bg-white text-blue-900 font-semibold rounded-lg hover:bg-blue-50 hover:scale-105 active:scale-95 transition-all duration-300 shadow-lg">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-8 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 hover:scale-105 active:scale-95 transition-all duration-300 shadow-lg">
                    Daftar
                </a>
            </div>
        @endauth
    </div>
</body>
</html>
