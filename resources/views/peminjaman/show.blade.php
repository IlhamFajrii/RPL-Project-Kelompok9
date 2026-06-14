@extends('layouts.app')
@section('title', 'Peminjaman')
@section('page-title', 'Detail Peminjaman')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Detail Peminjaman</h2>
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Alat</p>
                    <p class="text-lg font-semibold">{{ $peminjaman->alat->nama_alat }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Peminjam</p>
                    <p class="text-lg font-semibold">{{ $peminjaman->user->name }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Tanggal Pinjam</p>
                    <p class="text-lg font-semibold">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if($peminjaman->status_approval === 'approved')
                            bg-green-100 text-green-700
                        @elseif($peminjaman->status_approval === 'pending')
                            bg-yellow-100 text-yellow-700
                        @elseif($peminjaman->status_approval === 'rejected')
                            bg-red-100 text-red-700
                        @else
                            bg-blue-100 text-blue-700
                        @endif
                    ">{{ ucfirst($peminjaman->status_approval) }}</span>
                </div>
            </div>
            <a href="{{ route('peminjaman.index') }}" class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 mt-6">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
