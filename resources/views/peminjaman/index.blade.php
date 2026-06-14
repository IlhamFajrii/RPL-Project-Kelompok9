@extends('layouts.app')

@section('title', 'Daftar Peminjaman')
@section('page-title', 'Daftar Peminjaman')

@section('content')
@if(auth()->user()->isBlacklisted())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
        <div class="flex gap-3">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-semibold text-red-800">Akun Anda Masuk Blacklist</h3>
                <p class="text-sm text-red-700 mt-1">Anda saat ini masuk dalam daftar blacklist. Anda tidak dapat membuat peminjaman baru. Hubungi administrator untuk informasi lebih lanjut.</p>
            </div>
        </div>
    </div>
@endif

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Alat</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal Pinjam</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Rencana Kembali</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4">{{ $item->alat->nama_alat }}</td>
                    <td class="py-3 px-4">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                    <td class="py-3 px-4">{{ $item->tanggal_rencana_kembali->format('d M Y') }}</td>
                    <td class="py-3 px-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($item->status_approval === 'approved')
                                bg-green-100 text-green-700
                            @elseif($item->status_approval === 'pending')
                                bg-yellow-100 text-yellow-700
                            @elseif($item->status_approval === 'rejected')
                                bg-red-100 text-red-700
                            @else
                                bg-blue-100 text-blue-700
                            @endif
                        ">
                            {{ ucfirst($item->status_approval) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <a href="{{ route('peminjaman.show', $item) }}" class="text-blue-600 hover:underline font-semibold">Lihat</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">Tidak ada peminjaman</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($peminjaman->hasPages())
        <div class="mt-6">
            {{ $peminjaman->links() }}
        </div>
    @endif
</div>

@endsection
