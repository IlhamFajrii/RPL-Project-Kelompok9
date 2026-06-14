@extends('layouts.app')

@section('title', 'Tambah Alat')
@section('page-title', 'Tambah Alat')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form method="POST" action="{{ route('alat.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Kode Alat -->
            <div>
                <label for="kode_alat" class="block text-sm font-medium text-gray-700 mb-2">
                    Kode Alat <span class="text-red-600">*</span>
                </label>
                <input 
                    type="text" 
                    name="kode_alat" 
                    id="kode_alat"
                    value="{{ old('kode_alat') }}"
                    placeholder="Contoh: NET001"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kode_alat') border-red-500 @enderror"
                >
                @error('kode_alat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Alat -->
            <div>
                <label for="nama_alat" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Alat <span class="text-red-600">*</span>
                </label>
                <input 
                    type="text" 
                    name="nama_alat" 
                    id="nama_alat"
                    value="{{ old('nama_alat') }}"
                    placeholder="Masukkan nama alat"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_alat') border-red-500 @enderror"
                >
                @error('nama_alat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori <span class="text-red-600">*</span>
                </label>
                <input 
                    type="text" 
                    name="kategori" 
                    id="kategori"
                    value="{{ old('kategori') }}"
                    placeholder="Contoh: Networking, Computer, etc"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kategori') border-red-500 @enderror"
                >
                @error('kategori')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea 
                    name="deskripsi" 
                    id="deskripsi"
                    rows="4"
                    placeholder="Masukkan deskripsi alat (opsional)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror"
                >{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Alat
                </label>
                <input 
                    type="file" 
                    name="foto" 
                    id="foto"
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('foto') border-red-500 @enderror"
                >
                <p class="mt-1 text-xs text-gray-500">Format: JPEG, PNG, JPG, GIF (Maksimal 2MB)</p>
                @error('foto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stok -->
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Stok <span class="text-red-600">*</span>
                </label>
                <input 
                    type="number" 
                    name="stok" 
                    id="stok"
                    value="{{ old('stok', 1) }}"
                    min="1"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stok') border-red-500 @enderror"
                >
                @error('stok')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 hover:scale-105 active:scale-95 transition-all duration-300"
                >
                    Simpan Alat
                </button>
                <a 
                    href="{{ route('alat.index') }}" 
                    class="flex-1 bg-gray-300 text-gray-700 font-semibold py-2 rounded-lg hover:bg-gray-400 transition-all text-center"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@section('extra-js')
<script>
    // Form validation feedback
    document.querySelectorAll('input, textarea').forEach(field => {
        field.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.classList.add('border-red-500');
        });
        
        field.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.remove('border-red-500');
            }
        });
    });
</script>
@endsection

@endsection
