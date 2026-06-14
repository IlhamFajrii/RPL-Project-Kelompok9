@extends('layouts.app')

@section('title', 'Edit Blacklist')
@section('page-title', 'Edit Data Blacklist')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Edit Data Blacklist</h2>
        <p class="text-gray-600 mb-6">User: <span class="font-semibold">{{ $blacklist->user->name }}</span></p>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <div class="flex gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-red-800">Terjadi Kesalahan</h3>
                        <ul class="mt-2 text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('blacklist.update', $blacklist) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- User Info (Read-only) -->
            <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Nama User</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $blacklist->user->name }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $blacklist->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">NIM</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $blacklist->user->nomor_induk ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Alasan Blacklist -->
            <div>
                <label for="alasan" class="block text-sm font-semibold text-gray-700 mb-2">Alasan Blacklist *</label>
                <textarea name="alasan" id="alasan" required rows="5"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alasan') border-red-500 @enderror">{{ old('alasan', $blacklist->alasan) }}</textarea>
                <p class="mt-1 text-xs text-gray-600">Minimal 10 karakter</p>
                @error('alasan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai *</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                       value="{{ old('tanggal_mulai', $blacklist->tanggal_mulai->toDateString()) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_mulai') border-red-500 @enderror">
                @error('tanggal_mulai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Berakhir -->
            <div>
                <label for="tanggal_berakhir" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Berakhir</label>
                <input type="date" name="tanggal_berakhir" id="tanggal_berakhir"
                       value="{{ old('tanggal_berakhir', $blacklist->tanggal_berakhir?->toDateString() ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_berakhir') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-600">Kosongkan untuk blacklist permanen</p>
                @error('tanggal_berakhir')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Card -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Status Saat Ini</p>
                    <p class="text-lg font-bold mt-2">
                        @if($blacklist->isActive())
                            <span class="text-red-600">Aktif</span>
                        @else
                            <span class="text-green-600">Tidak Aktif</span>
                        @endif
                    </p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Dibuat Pada</p>
                    <p class="text-sm font-semibold mt-2">{{ $blacklist->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <!-- Aktif Checkbox -->
            <div class="border-t border-gray-200 pt-6">
                <label class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $blacklist->aktif))
                           class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <div>
                        <span class="text-sm font-semibold text-gray-700">Aktifkan Blacklist</span>
                        <p class="text-xs text-gray-600 mt-0.5">Centang untuk membuat blacklist ini aktif</p>
                    </div>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-all font-semibold">
                    Perbarui Data
                </button>
                <a href="{{ route('blacklist.index') }}" class="flex-1 text-center bg-gray-400 text-white px-6 py-3 rounded-lg hover:bg-gray-500 transition-all font-semibold">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
