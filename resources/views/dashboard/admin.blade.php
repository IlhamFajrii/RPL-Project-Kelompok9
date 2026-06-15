<?php
/**
 * @var array $chartData
 * @var array $statusChartData
 * @var int $totalAlat
 * @var int $alatTersedia
 * @var int $alatDipinjam
 * @var int $totalUser
 * @var int $totalPeminjaman
 * @var int $alatRusak
 * @var int $peminjamanPending
 * @var int $peminjamanApproved
 * @var int $peminjamanReturned
 * @var int $peminjamanRejected
 * @var int $peminjamanTerlambat
 * @var \Illuminate\Database\Eloquent\Collection $topAlat
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
                <svg class="w-12 h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <!-- Package with checkmark -->
                    <circle cx="12" cy="12" r="10" class="text-green-200" fill="currentColor"></circle>
                    <path d="M8 12.5l2 2 4-4" class="text-white" stroke="white" stroke-width="3"></path>
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

    <!-- Peminjaman Status Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Pending</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2 count-up" id="count-pending">{{ $peminjamanPending }}</p>
                </div>
                <svg class="w-12 h-12 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Approved</p>
                    <p class="text-3xl font-bold text-green-600 mt-2 count-up" id="count-approved">{{ $peminjamanApproved }}</p>
                </div>
                <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Returned</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2 count-up" id="count-returned">{{ $peminjamanReturned }}</p>
                </div>
                <svg class="w-12 h-12 text-blue-300" viewBox="0 0 24 24" fill="currentColor">
                    <!-- Undo/Return Arrow Icon -->
                    <circle cx="12" cy="12" r="10" class="text-blue-200" fill="currentColor"></circle>
                    <path d="M7 12a5 5 0 0110 0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"></path>
                    <path d="M7 12L4 9m0 0l3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Rejected</p>
                    <p class="text-3xl font-bold text-red-600 mt-2 count-up" id="count-rejected">{{ $peminjamanRejected }}</p>
                </div>
                <svg class="w-12 h-12" viewBox="0 0 24 24" fill="currentColor">
                    <!-- X Circle Icon -->
                    <circle cx="12" cy="12" r="10" class="text-red-200" fill="currentColor"></circle>
                    <path d="M15 9l-6 6M9 9l6 6" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-red-500"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Terlambat</p>
                    <p class="text-3xl font-bold text-red-500 mt-2 count-up" id="count-terlambat">{{ $peminjamanTerlambat }}</p>
                </div>
                <svg class="w-12 h-12 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    
<!-- Chart and Statistics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Monthly Trend Chart -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Tren Peminjaman (12 Bulan Terakhir)</h3>
            <canvas id="chart-peminjaman" height="80"></canvas>
        </div>

        <!-- Status Distribution Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Distribusi Status</h3>
            <canvas id="chart-status"></canvas>
        </div>
    </div>

    <!-- Top Equipment Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Equipment -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Top 5 Alat Paling Dipinjam</h3>
            <div class="space-y-3">
                @forelse($topAlat as $index => $alat)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-600 text-white text-sm font-bold rounded-full mr-3">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <p class="font-medium text-gray-800">{{ $alat->nama_alat }}</p>
                            <p class="text-xs text-gray-500">Stok: {{ $alat->stok }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-semibold rounded-full">
                        {{ $alat->peminjaman_count }} kali
                    </span>
                </div>
                @empty
                <p class="text-center text-gray-500 py-4">Tidak ada data peminjaman</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Ringkasan Statistik</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Total Peminjaman</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $totalPeminjaman }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Selesai (Returned)</span>
                    <span class="text-2xl font-bold text-green-600">{{ $peminjamanReturned }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Menunggu Persetujuan</span>
                    <span class="text-2xl font-bold text-yellow-600">{{ $peminjamanPending }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <span class="text-sm font-medium text-gray-700">Terlambat Dikembalikan</span>
                    <span class="text-2xl font-bold text-red-600">{{ $peminjamanTerlambat }}</span>
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

    window.statusData = {
        labels: <?php echo json_encode($statusChartData['labels']); ?>,
        data: <?php echo json_encode($statusChartData['data']); ?>,
        colors: <?php echo json_encode($statusChartData['colors']); ?>
    };

    function initChart() {
        // Line Chart for monthly trends
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

        // Doughnut Chart for status distribution
        const statusCtx = document.getElementById('chart-status');
        if (statusCtx && window.statusData && window.statusData.data) {
            try {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: window.statusData.labels,
                        datasets: [{
                            data: window.statusData.data,
                            backgroundColor: window.statusData.colors,
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            } catch(e) {
                console.error('Status chart initialization error:', e);
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
            { id: 'count-user' },
            { id: 'count-pending' },
            { id: 'count-approved' },
            { id: 'count-returned' },
            { id: 'count-rejected' },
            { id: 'count-terlambat' }
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
