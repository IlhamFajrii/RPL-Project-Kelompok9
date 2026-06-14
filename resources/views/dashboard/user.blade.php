@extends('layouts.app')

@section('title', 'Dashboard Pengguna')
@section('page-title', 'Dashboard Saya')

@section('content')
<div class="space-y-6">
    @if($statusBlacklist)
        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg">
            <p class="font-semibold">⚠️ Anda sedang dalam status blacklist</p>
            <p class="text-sm mt-2">Anda tidak dapat meminjam alat saat ini. Silahkan hubungi laboran untuk informasi lebih lanjut.</p>
        </div>
    @endif

    <!-- Pengajuan Aktif -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Pengajuan Aktif</h3>
        
        @if($pengajuanAktif->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($pengajuanAktif as $peminjaman)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="font-semibold text-gray-800">{{ $peminjaman->alat->nama_alat }}</h4>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($peminjaman->status_approval === 'approved')
                                bg-green-100 text-green-700
                            @else
                                bg-yellow-100 text-yellow-700
                            @endif
                        ">
                            {{ ucfirst($peminjaman->status_approval) }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Tanggal Pinjam: <strong>{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</strong></p>
                        <p>Rencana Kembali: <strong>{{ $peminjaman->tanggal_rencana_kembali->format('d M Y') }}</strong></p>
                    </div>
                    <a href="{{ route('peminjaman.show', $peminjaman) }}" class="mt-3 inline-block text-blue-600 hover:underline text-sm font-semibold">
                        Lihat Detail →
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Tidak ada pengajuan aktif</p>
        @endif
    </div>

    <!-- Alat Populer -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Alat Populer</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($alatPopuler as $alat)
            <a href="{{ route('alat.show', $alat) }}" class="border border-gray-200 rounded-lg p-4 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <p class="text-sm text-gray-600">{{ $alat->kategori }}</p>
                <h4 class="font-semibold text-gray-800 mt-2">{{ $alat->nama_alat }}</h4>
                <div class="mt-3 flex justify-between items-center">
                    <span class="text-xs text-gray-500">{{ $alat->peminjaman_count }} peminjaman</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($alat->stok_tersedia > 0)
                            bg-green-100 text-green-700
                        @else
                            bg-red-100 text-red-700
                        @endif
                    ">
                        {{ $alat->stok_tersedia > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                </div>
            </a>
            @empty
            <p class="col-span-full text-center text-gray-500 py-8">Tidak ada alat populer</p>
            @endforelse
        </div>
    </div>

    <!-- Riwayat Peminjaman -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Riwayat Peminjaman</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Alat</th>
                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Tanggal Pinjam</th>
                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Rencana Kembali</th>
                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPeminjaman as $peminjaman)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4">{{ $peminjaman->alat->nama_alat }}</td>
                        <td class="py-3 px-4">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="py-3 px-4">{{ $peminjaman->tanggal_rencana_kembali->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($peminjaman->status_approval === 'approved')
                                    bg-green-100 text-green-700
                                @elseif($peminjaman->status_approval === 'pending')
                                    bg-yellow-100 text-yellow-700
                                @elseif($peminjaman->status_approval === 'rejected')
                                    bg-red-100 text-red-700
                                @else
                                    bg-blue-100 text-blue-700
                                @endif
                            ">
                                {{ ucfirst($peminjaman->status_approval) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Belum ada riwayat peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
