@extends('layouts.app')

@section('title', 'Tambah ke Blacklist')
@section('page-title', 'Tambah User ke Blacklist')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambahkan User ke Blacklist</h2>

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

        <form action="{{ route('blacklist.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- User Selection -->
            <div>
                <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih User *</label>
                <select name="user_id" id="user_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('user_id') border-red-500 @enderror">
                    <option value="">-- Pilih User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alasan Blacklist -->
            <div>
                <label for="alasan" class="block text-sm font-semibold text-gray-700 mb-2">Alasan Blacklist *</label>
                <textarea name="alasan" id="alasan" required rows="5"
                          placeholder="Jelaskan secara detail alasan user ini di-blacklist..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('alasan') border-red-500 @enderror">{{ old('alasan') }}</textarea>
                <p class="mt-1 text-xs text-gray-600">Minimal 10 karakter</p>
                @error('alasan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Mulai -->
            <div>
                <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai *</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                       value="{{ old('tanggal_mulai', now()->toDateString()) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('tanggal_mulai') border-red-500 @enderror">
                @error('tanggal_mulai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Berakhir -->
            <div>
                <label for="tanggal_berakhir" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Berakhir</label>
                <input type="date" name="tanggal_berakhir" id="tanggal_berakhir"
                       value="{{ old('tanggal_berakhir') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('tanggal_berakhir') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-600">Kosongkan untuk blacklist permanen</p>
                @error('tanggal_berakhir')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Aktif Checkbox -->
            <div>
                <label class="flex items-center gap-3">
                    <input type="checkbox" name="aktif" value="1" @checked(old('aktif', true))
                           class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <span class="text-sm font-semibold text-gray-700">Aktifkan blacklist sekarang</span>
                </label>
            </div>

            <!-- Info Box -->
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                <div class="flex gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-red-800">Perhatian</h3>
                        <p class="text-sm text-red-700 mt-1">User yang di-blacklist tidak akan dapat melakukan peminjaman alat sampai status blacklist tidak aktif atau dihapus.</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-3 pt-6">
                <button type="submit" class="flex-1 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-all font-semibold">
                    Tambahkan ke Blacklist
                </button>
                <a href="{{ route('blacklist.index') }}" class="flex-1 text-center bg-gray-400 text-white px-6 py-3 rounded-lg hover:bg-gray-500 transition-all font-semibold">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-set end date to 30 days from start date
    document.getElementById('tanggal_mulai').addEventListener('change', function() {
        if (!document.getElementById('tanggal_berakhir').value) {
            const startDate = new Date(this.value);
            const endDate = new Date(startDate.getTime() + (30 * 24 * 60 * 60 * 1000));
            document.getElementById('tanggal_berakhir').value = endDate.toISOString().split('T')[0];
        }
    });
</script>

@endsection
