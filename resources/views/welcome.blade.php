<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPAL - Sistem Peminjaman Alat Laboratorium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .welcome-container {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-background {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 300px;
            opacity: 0.1;
            z-index: 1;
            pointer-events: none;
        }

        .logo-background img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .content-wrapper h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: white;
        }

        .content-wrapper p {
            color: white;
            margin-bottom: 0.5rem;
        }

        .content-wrapper .subtitle {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .content-wrapper .description {
            font-size: 1.125rem;
            color: #bfdbfe;
            margin-bottom: 2rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .button-group a {
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-login {
            background-color: white;
            color: #1e3a8a;
        }

        .btn-login:hover {
            background-color: #f3f4f6;
            transform: scale(1.05);
        }

        .btn-register {
            background-color: #3b82f6;
            color: white;
        }

        .btn-register:hover {
            background-color: #2563eb;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 min-h-screen">
    <div class="welcome-container w-full">
        <!-- Background Logo SMKN 2 Palembang -->
        <div class="logo-background">
            <img src="{{ asset('images/logo-smkn2.jpg') }}" alt="SMKN 2 Palembang Logo">
        </div>

        <div class="content-wrapper max-w-2xl px-4">
            @auth
                <script>window.location.href = "{{ route('dashboard') }}"</script>
            @else
                <h1>SPAL</h1>
                <p class="subtitle">Sistem Peminjaman Alat Laboratorium</p>
                <p class="description">SMKN 2 Palembang</p>
            
                <div class="button-group">
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</body>
</html>
