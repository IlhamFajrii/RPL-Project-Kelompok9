@extends('layouts.app')

@section('title', 'Katalog Alat')
@section('page-title', 'Katalog Alat')

@section('content')
<div class="space-y-6">
    @if(auth()->check() && auth()->user()->isBlacklisted())
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
            <div class="flex gap-3">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-red-800">Akun Anda Masuk Blacklist</h3>
                    <p class="text-sm text-red-700 mt-1">Anda saat ini masuk dalam daftar blacklist dan tidak dapat melakukan peminjaman alat. Hubungi administrator jika ada pertanyaan.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="GET" action="{{ route('alat.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Alat</label>
                <input 
                    type="text" 
                    name="search" 
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Nama atau kode alat..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="kategori" id="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" @selected(request('kategori') === $kat)>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Status --</option>
                    <option value="tersedia" @selected(request('status') === 'tersedia')>Tersedia</option>
                    <option value="dipinjam" @selected(request('status') === 'dipinjam')>Dipinjam</option>
                    <option value="rusak" @selected(request('status') === 'rusak')>Rusak</option>
                    <option value="maintenance" @selected(request('status') === 'maintenance')>Maintenance</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all duration-300">
                    Cari
                </button>
                <a href="{{ route('alat.index') }}" class="flex-1 bg-gray-300 text-gray-700 font-semibold py-2 rounded-lg hover:bg-gray-400 transition-all text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Alat Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($alat as $item)
        <div class="bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
            @if($item->foto)
                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_alat }}" class="w-full h-48 object-cover">
            @else
                <div class="w-full h-48 bg-gradient-to-br from-blue-200 to-purple-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m0-4v10l-8 4"></path>
                    </svg>
                </div>
            @endif

            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <p class="text-xs text-gray-500">{{ $item->kategori }}</p>
                        <h3 class="font-semibold text-gray-800 mt-1">{{ $item->nama_alat }}</h3>
                    </div>
                    <span class="text-xs font-semibold px-2 py-1 rounded-full
                        @if($item->status === 'tersedia')
                            bg-green-100 text-green-700
                        @elseif($item->status === 'dipinjam')
                            bg-yellow-100 text-yellow-700
                        @elseif($item->status === 'rusak')
                            bg-red-100 text-red-700
                        @else
                            bg-gray-100 text-gray-700
                        @endif
                    ">
                        {{ ucfirst($item->status) }}
                    </span>
                </div>

                <p class="text-sm text-gray-600 mb-3">Kode: {{ $item->kode_alat }}</p>
                
                <div class="text-sm text-gray-700 mb-4">
                    <p>Stok: <strong>{{ $item->stok }}</strong></p>
                    <p>Tersedia: <strong>{{ $item->stok_tersedia }}</strong></p>
                </div>

                @if($item->deskripsi)
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $item->deskripsi }}</p>
                @endif

                <div class="flex gap-2">
                    <a href="{{ route('alat.show', $item) }}" class="flex-1 bg-blue-600 text-white text-sm font-semibold py-2 rounded-lg hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all text-center">
                        Lihat Detail
                    </a>
                    @if($item->stok_tersedia > 0 && !auth()->user()->isBlacklisted())
                        <a href="{{ route('peminjaman.create', $item) }}" class="flex-1 bg-green-600 text-white text-sm font-semibold py-2 rounded-lg hover:bg-green-700 hover:scale-105 active:scale-95 transition-all text-center">
                            Pinjam
                        </a>
                    @elseif(auth()->user()->isBlacklisted())
                        <button disabled class="flex-1 bg-gray-400 text-gray-700 text-sm font-semibold py-2 rounded-lg cursor-not-allowed text-center" title="Anda tidak dapat meminjam karena masuk blacklist">
                            Pinjam
                        </button>
                    @elseif($item->stok_tersedia <= 0)
                        <button disabled class="flex-1 bg-gray-400 text-gray-700 text-sm font-semibold py-2 rounded-lg cursor-not-allowed text-center" title="Alat tidak tersedia">
                            Pinjam
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m0-4v10l-8 4"></path>
            </svg>
            <p class="text-gray-500 text-lg">Tidak ada alat ditemukan</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($alat->hasPages())
        <div class="flex justify-center mt-8">
            {{ $alat->links() }}
        </div>
    @endif
</div>

@endsection
