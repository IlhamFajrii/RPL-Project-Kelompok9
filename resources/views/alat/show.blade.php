@extends('layouts.app')

@section('title', $alat->nama_alat)
@section('page-title', $alat->nama_alat)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($alat->foto)
                <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}" class="w-full h-96 object-cover">
            @else
                <div class="w-full h-96 bg-gradient-to-br from-blue-200 to-purple-200 flex items-center justify-center">
                    <svg class="w-24 h-24 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m0-4v10l-8 4"></path>
                    </svg>
                </div>
            @endif

            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-600">{{ $alat->kategori }}</p>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $alat->nama_alat }}</h1>
                    </div>
                    <span class="text-xl font-semibold px-4 py-2 rounded-full
                        @if($alat->status === 'tersedia')
                            bg-green-100 text-green-700
                        @elseif($alat->status === 'dipinjam')
                            bg-yellow-100 text-yellow-700
                        @elseif($alat->status === 'rusak')
                            bg-red-100 text-red-700
                        @else
                            bg-gray-100 text-gray-700
                        @endif
                    ">
                        {{ ucfirst($alat->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm text-gray-600">Kode Alat</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $alat->kode_alat }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Stok</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $alat->stok }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Stok Tersedia</p>
                        <p class="text-lg font-semibold
                            @if($alat->stok_tersedia > 0)
                                text-green-600
                            @else
                                text-red-600
                            @endif
                        ">{{ $alat->stok_tersedia }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Sedang Dipinjam</p>
                        <p class="text-lg font-semibold text-blue-600">{{ $alat->peminjaman->count() }}</p>
                    </div>
                </div>

                @if($alat->deskripsi)
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Deskripsi</h3>
                        <p class="text-gray-700">{{ $alat->deskripsi }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
            <h3 class="text-lg font-semibold mb-4">Aksi</h3>

            @if($alat->stok_tersedia > 0)
                @if(!auth()->user()->isBlacklisted())
                    <a href="{{ route('peminjaman.create', $alat) }}" class="w-full bg-green-600 text-white font-semibold py-3 rounded-lg hover:bg-green-700 hover:scale-105 active:scale-95 transition-all text-center block mb-3">
                        Pinjam Alat
                    </a>
                @else
                    <div class="w-full bg-gray-400 text-white font-semibold py-3 rounded-lg text-center mb-3 cursor-not-allowed">
                        Pinjam Alat (Blacklist)
                    </div>
                @endif
            @else
                <div class="w-full bg-gray-400 text-white font-semibold py-3 rounded-lg text-center mb-3 cursor-not-allowed">
                    Alat Tidak Tersedia
                </div>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isLaboran())
                <a href="{{ route('alat.edit', $alat) }}" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 text-center block mb-2">
                    Edit
                </a>

                <form method="POST" action="{{ route('alat.destroy', $alat) }}" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Yakin ingin menghapus?')">
                        Hapus
                    </button>
                </form>
            @endif
        </div>

        @if($alat->peminjaman->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Sedang Dipinjam</h3>
                <div class="space-y-3">
                    @foreach($alat->peminjaman as $peminjaman)
                    <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                        <p class="font-semibold text-sm">{{ $peminjaman->user->name }}</p>
                        <p class="text-xs text-gray-600 mt-1">
                            Kembali: {{ $peminjaman->tanggal_rencana_kembali->format('d M Y') }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
