<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin() || $user->isLaboran()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $totalAlat = Alat::count();
        $alatTersedia = Alat::where('status', 'tersedia')->sum('stok_tersedia');
        $alatDipinjam = Peminjaman::where('status_approval', 'approved')
            ->whereNull('tanggal_kembali')
            ->count();
        $alatRusak = Alat::where('status', 'rusak')->sum('stok');

        $totalUser = User::where('role', 'user')->count();
        $totalPeminjaman = Peminjaman::count();

        // Statistik peminjaman berdasarkan status
        $peminjamanPending = Peminjaman::where('status_approval', 'pending')->count();
        $peminjamanApproved = Peminjaman::where('status_approval', 'approved')->count();
        $peminjamanReturned = Peminjaman::where('status_approval', 'returned')->count();
        $peminjamanRejected = Peminjaman::where('status_approval', 'rejected')->count();
        
        // Statistik keterlambatan
        $peminjamanTerlambat = Peminjaman::where('status_approval', 'approved')
            ->whereNull('tanggal_kembali')
            ->whereDate('tanggal_rencana_kembali', '<', now()->toDateString())
            ->count();

        // Chart data - Monthly peminjaman
        $chartData = $this->getMonthlyChartData();
        $statusChartData = $this->getStatusChartData();

        // Top alat yang dipinjam
        $topAlat = Alat::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        // Recent activity
        $aktivitasTerbaru = Peminjaman::with(['user', 'alat'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.admin', compact(
            'totalAlat',
            'alatTersedia',
            'alatDipinjam',
            'alatRusak',
            'totalUser',
            'totalPeminjaman',
            'peminjamanPending',
            'peminjamanApproved',
            'peminjamanReturned',
            'peminjamanRejected',
            'peminjamanTerlambat',
            'chartData',
            'statusChartData',
            'topAlat',
            'aktivitasTerbaru'
        ));
    }

    private function userDashboard()
    {
        $user = auth()->user();

        $pengajuanAktif = $user->peminjaman()
            ->whereIn('status_approval', ['pending', 'approved'])
            ->whereNull('tanggal_kembali')
            ->with('alat')
            ->latest()
            ->take(5)
            ->get();

        $riwayatPeminjaman = $user->peminjaman()
            ->with('alat')
            ->latest()
            ->take(10)
            ->get();

        $alatPopuler = Alat::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(6)
            ->get();

        $statusBlacklist = $user->isBlacklisted();

        return view('dashboard.user', compact(
            'pengajuanAktif',
            'riwayatPeminjaman',
            'alatPopuler',
            'statusBlacklist'
        ));
    }

    private function getMonthlyChartData()
    {
        $months = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');

            $count = Peminjaman::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $data[] = $count;
        }

        return [
            'months' => $months,
            'data' => $data,
        ];
    }

    private function getStatusChartData()
    {
        $pending = Peminjaman::where('status_approval', 'pending')->count();
        $approved = Peminjaman::where('status_approval', 'approved')->count();
        $returned = Peminjaman::where('status_approval', 'returned')->count();
        $rejected = Peminjaman::where('status_approval', 'rejected')->count();

        return [
            'labels' => ['Pending', 'Approved', 'Returned', 'Rejected'],
            'data' => [$pending, $approved, $returned, $rejected],
            'colors' => ['#FCD34D', '#10B981', '#3B82F6', '#EF4444'],
        ];
    }
}
