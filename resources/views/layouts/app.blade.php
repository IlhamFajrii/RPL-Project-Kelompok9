<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SPAL') }} - @yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3/dist/chart.min.js"></script>

        <!-- CountUp.js -->
        <script src="https://cdn.jsdelivr.net/npm/countup.js@2/dist/countUp.min.js"></script>

        @yield('extra-css')
    </head>
    <body class="font-inter bg-slate-50">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            @auth
            <nav class="w-64 bg-blue-900 text-white sidebar-nav">
                <div class="p-6">
                    <h1 class="text-2xl font-bold">SPAL</h1>
                    <p class="text-sm text-blue-200">Sistem Peminjaman Alat</p>
                </div>

                <ul class="mt-8">
                    <li>
                        <a href="{{ route('dashboard') }}" class="nav-link group flex items-center px-6 py-3 hover:bg-blue-800 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h2a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h2a1 1 0 001-1V9m-9 0l7-4 7 4m0 0a2 2 0 100-4 2 2 0 000 4"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('alat.index') }}" class="nav-link group flex items-center px-6 py-3 hover:bg-blue-800 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m0-4v10l-8 4"></path>
                            </svg>
                            Katalog Alat
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('peminjaman.index') }}" class="nav-link group flex items-center px-6 py-3 hover:bg-blue-800 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Peminjaman
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin() || auth()->user()->isLaboran())
                    <li class="mt-6 pt-6 border-t border-blue-700">
                        <p class="px-6 text-xs font-semibold text-blue-300 uppercase">Manajemen</p>
                    </li>

                    <li>
                        <a href="{{ route('approval.index') }}" class="nav-link group flex items-center px-6 py-3 hover:bg-blue-800 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m0 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Approval
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('alat.create') }}" class="nav-link group flex items-center px-6 py-3 hover:bg-blue-800 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Kelola Alat
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('report.index') }}" class="nav-link group flex items-center px-6 py-3 hover:bg-blue-800 transition-all duration-300">
                            <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Laporan
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
            @endauth

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Top Bar -->
                @auth
                <div class="bg-white border-b border-gray-200 shadow-sm">
                    <div class="flex justify-between items-center px-6 py-4">
                        <h2 class="text-xl font-semibold text-gray-800">@yield('page-title')</h2>
                        
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                            </div>
                            
                            <button class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold hover:bg-blue-200 transition-colors duration-300">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </button>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-600 hover:text-red-600 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Page Content -->
                <main class="flex-1 p-6">
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg animate-in slide-in-from-top-2">
                            <strong>Error!</strong>
                            <ul class="mt-2 ml-4 list-disc">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg animate-in slide-in-from-top-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg animate-in slide-in-from-top-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>

        @yield('extra-js')
    </body>
</html>
