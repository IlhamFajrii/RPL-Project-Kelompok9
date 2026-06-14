@extends('layouts.app')
@section('title', 'Approval Detail')
@section('page-title', 'Detail Approval')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg col-span-2">
                    <p class="text-sm text-gray-600">Peminjam</p>
                    <p class="text-lg font-semibold">{{ $peminjaman->user->name }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $peminjaman->user->email }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Alat</p>
                    <p class="text-lg font-semibold">{{ $peminjaman->alat->nama_alat }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if($peminjaman->status_approval === 'approved')
                            bg-green-100 text-green-700
                        @elseif($peminjaman->status_approval === 'pending')
                            bg-yellow-100 text-yellow-700
                        @else
                            bg-red-100 text-red-700
                        @endif
                    ">{{ ucfirst($peminjaman->status_approval) }}</span>
                </div>
            </div>
            <a href="{{ route('approval.index') }}" class="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 mt-6">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
