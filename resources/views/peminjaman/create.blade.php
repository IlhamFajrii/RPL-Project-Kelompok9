@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-3xl font-bold mb-6">Formulir Pengajuan Peminjaman</h1>

        <!-- Equipment Info -->
        <div class="bg-blue-50 rounded-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Nama Alat</p>
                    <p class="text-xl font-semibold">{{ $alat->nama_alat }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Kode Alat</p>
                    <p class="text-xl font-semibold">{{ $alat->kode_alat }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Kategori</p>
                    <p class="text-lg">{{ $alat->kategori }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status Ketersediaan</p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if($alat->status === 'tersedia') bg-green-100 text-green-800
                        @elseif($alat->status === 'dipinjam') bg-yellow-100 text-yellow-800
                        @elseif($alat->status === 'rusak') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($alat->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-600">Stok Tersedia</p>
                    <p class="text-lg font-semibold text-green-600">{{ $alat->stok_tersedia }} dari {{ $alat->stok }}</p>
                </div>
            </div>
            @if($alat->deskripsi)
                <div class="mt-4">
                    <p class="text-gray-600">Deskripsi</p>
                    <p class="text-gray-700">{{ $alat->deskripsi }}</p>
                </div>
            @endif
        </div>

        <!-- Form -->
        <form action="{{ route('peminjaman.store', $alat) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="jumlah" class="block text-gray-700 font-semibold mb-2">
                    Jumlah Peminjaman <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-2">
                    <input 
                        type="number" 
                        id="jumlah" 
                        name="jumlah"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ old('jumlah', 1) }}"
                        min="1"
                        max="{{ $alat->stok_tersedia }}"
                        required
                    >
                    <span class="text-gray-600 text-sm">Maks: {{ $alat->stok_tersedia }}</span>
                </div>
                @error('jumlah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tanggal_rencana_kembali" class="block text-gray-700 font-semibold mb-2">
                    Tanggal Rencana Kembali <span class="text-red-500">*</span>
                </label>
                <input 
                    type="datetime-local" 
                    id="tanggal_rencana_kembali" 
                    name="tanggal_rencana_kembali"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ old('tanggal_rencana_kembali') }}"
                    required
                    min="{{ now()->format('Y-m-d\TH:i') }}"
                >
                @error('tanggal_rencana_kembali')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <p class="text-yellow-700">
                    <strong>Catatan:</strong> Pastikan Anda mengisi tanggal pengembalian dengan akurat. 
                    Keterlambatan pengembalian dapat menyebabkan pembatasan peminjaman.
                </p>
            </div>

            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition"
                >
                    Ajukan Peminjaman
                </button>
                <a 
                    href="{{ route('alat.show', $alat) }}" 
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg text-center transition"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
