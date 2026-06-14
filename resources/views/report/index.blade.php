@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan Peminjaman')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold mb-6">Generate Laporan</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- PDF Export -->
            <div class="border-2 border-dashed border-blue-300 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-blue-600">📄 Export PDF</h3>
                <form method="POST" action="{{ route('report.pdf') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="pdf_periode" class="block text-sm font-medium mb-2">Periode</label>
                        <select name="periode" id="pdf_periode" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="harian">Harian</option>
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan" selected>Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                    </div>

                    <div>
                        <label for="pdf_tgl_awal" class="block text-sm font-medium mb-2">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" id="pdf_tgl_awal" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ now()->subMonth()->format('Y-m-d') }}">
                    </div>

                    <div>
                        <label for="pdf_tgl_akhir" class="block text-sm font-medium mb-2">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" id="pdf_tgl_akhir" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
                        Download PDF
                    </button>
                </form>
            </div>

            <!-- Excel Export -->
            <div class="border-2 border-dashed border-green-300 rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-green-600">📊 Export Excel</h3>
                <form method="POST" action="{{ route('report.excel') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="excel_periode" class="block text-sm font-medium mb-2">Periode</label>
                        <select name="periode" id="excel_periode" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="harian">Harian</option>
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan" selected>Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                    </div>

                    <div>
                        <label for="excel_tgl_awal" class="block text-sm font-medium mb-2">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" id="excel_tgl_awal" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ now()->subMonth()->format('Y-m-d') }}">
                    </div>

                    <div>
                        <label for="excel_tgl_akhir" class="block text-sm font-medium mb-2">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" id="excel_tgl_akhir" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 font-semibold">
                        Download Excel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
