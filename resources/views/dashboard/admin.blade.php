<?php
/**
 * @var array $chartData
 * @var int $totalAlat
 * @var int $alatTersedia
 * @var int $alatDipinjam
 * @var int $totalUser
 * @var int $totalPeminjaman
 * @var int $alatRusak
 * @var \Illuminate\Database\Eloquent\Collection $aktivitasTerbaru
 */
?>
@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Alat</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2 count-up" id="count-alat">{{ $totalAlat }}</p>
                </div>
                <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m0-4v10l-8 4"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Alat Tersedia</p>
                    <p class="text-3xl font-bold text-green-600 mt-2 count-up" id="count-tersedia">{{ $alatTersedia }}</p>
                </div>
                <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m0 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Alat Dipinjam</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2 count-up" id="count-dipinjam">{{ $alatDipinjam }}</p>
                </div>
                <svg class="w-12 h-12 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total User</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2 count-up" id="count-user">{{ $totalUser }}</p>
                </div>
                <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.697"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Chart and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Statistik Peminjaman (12 Bulan Terakhir)</h3>
            <canvas id="chart-peminjaman" height="80"></canvas>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Quick Stats</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Total Peminjaman</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $totalPeminjaman }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Alat Rusak</span>
                    <span class="text-2xl font-bold text-red-600">{{ $alatRusak }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Aktivitas Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Peminjam</th>
                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Alat</th>
                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Tanggal Pinjam</th>
                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aktivitasTerbaru as $peminjaman)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4">{{ $peminjaman->user->name }}</td>
                        <td class="py-3 px-4">{{ $peminjaman->alat->nama_alat }}</td>
                        <td class="py-3 px-4">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</td>
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
                        <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada aktivitas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    window.chartData = {
        months: <?php echo json_encode($chartData['months']); ?>,
        data: <?php echo json_encode($chartData['data']); ?>
    };

    function initChart() {
        const ctx = document.getElementById('chart-peminjaman');
        if (ctx && window.chartData && window.chartData.data && window.chartData.data.length > 0) {
            try {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: window.chartData.months,
                        datasets: [{
                            label: 'Peminjaman',
                            data: window.chartData.data,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 5,
                            pointBackgroundColor: '#3b82f6',
                            pointHoverRadius: 7,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: Math.max(...window.chartData.data) + 5
                            }
                        }
                    }
                });
            } catch(e) {
                console.error('Chart initialization error:', e);
            }
        }
    }

    function initCountUp() {
        if (typeof CountUp === 'undefined') {
            console.warn('CountUp library not loaded');
            return;
        }

        const countElements = [
            { id: 'count-alat' },
            { id: 'count-tersedia' },
            { id: 'count-dipinjam' },
            { id: 'count-user' }
        ];

        countElements.forEach(item => {
            const element = document.getElementById(item.id);
            if (element) {
                try {
                    const finalValue = parseInt(element.textContent);
                    const counter = new CountUp(item.id, finalValue, {
                        duration: 2,
                        useEasing: true,
                    });
                    counter.start();
                } catch(e) {
                    console.log('CountUp error for ' + item.id + ':', e);
                }
            }
        });
    }

    function initDashboard() {
        initChart();
        initCountUp();
    }

    // Initialize when chart library is available
    function waitForChart() {
        if (typeof Chart !== 'undefined') {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initDashboard);
            } else {
                initDashboard();
            }
        } else {
            setTimeout(waitForChart, 50);
        }
    }

    waitForChart();
</script>
@endsection

@endsection
