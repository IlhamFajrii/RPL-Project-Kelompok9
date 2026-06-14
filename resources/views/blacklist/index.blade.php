@extends('layouts.app')

@section('title', 'Manajemen Blacklist')
@section('page-title', 'Manajemen Blacklist')

@section('content')
<div class="space-y-6">
    <!-- Header dengan tombol tambah -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Blacklist User</h1>
            <p class="text-gray-600 mt-1">Kelola pengguna yang dilarang untuk meminjam alat</p>
        </div>
        <a href="{{ route('blacklist.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-all font-semibold">
            + Tambah ke Blacklist
        </a>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="GET" action="{{ route('blacklist.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari User</label>
                    <input type="text" name="search" placeholder="Nama, Email, atau NIM..." 
                           value="{{ request('search') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">-- Semua Status --</option>
                        <option value="active" @selected(request('status') === 'active')>Aktif</option>
                        <option value="expired" @selected(request('status') === 'expired')>Expired</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all font-semibold">
                        Filter
                    </button>
                    <a href="{{ route('blacklist.index') }}" class="flex-1 text-center bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition-all font-semibold">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Blacklist -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b-2 border-gray-300">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama User</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">NIM</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Alasan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal Mulai</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal Berakhir</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blacklist as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $item->user->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $item->user->email }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $item->user->nomor_induk ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700 max-w-xs truncate inline-block" title="{{ $item->alasan }}">
                                {{ Str::limit($item->alasan, 40) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $item->tanggal_mulai->format('d M Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">
                                @if($item->tanggal_berakhir)
                                    {{ $item->tanggal_berakhir->format('d M Y') }}
                                @else
                                    <span class="text-red-600 font-semibold">Permanen</span>
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->isActive())
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('blacklist.edit', $item) }}" 
                                   class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition-all text-sm font-semibold">
                                    Edit
                                </a>
                                <form action="{{ route('blacklist.destroy', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data blacklist ini?')"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-all text-sm font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">
                            <p class="text-lg">Tidak ada data blacklist</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($blacklist->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $blacklist->links() }}
            </div>
        @endif
    </div>

    <!-- Info Box -->
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
        <div class="flex gap-3">
            <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="font-semibold text-yellow-800">Informasi Penting</h3>
                <p class="text-sm text-yellow-700 mt-1">User yang masuk dalam daftar blacklist tidak dapat melakukan peminjaman alat. Blacklist otomatis akan dihapus ketika tanggal berakhir sudah tiba.</p>
            </div>
        </div>
    </div>
</div>

@endsection
