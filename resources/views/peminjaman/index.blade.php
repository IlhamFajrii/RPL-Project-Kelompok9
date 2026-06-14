@extends('layouts.app')

@section('title', 'Daftar Peminjaman')
@section('page-title', 'Daftar Peminjaman')

@section('content')
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
