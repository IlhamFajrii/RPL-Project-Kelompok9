<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelWriter;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function generatePDF(Request $request)
    {
        $validated = $request->validate([
            'periode' => 'required|in:harian,mingguan,bulanan,tahunan',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after:tgl_awal',
        ]);

        $peminjaman = Peminjaman::with(['user', 'alat'])
            ->whereBetween('created_at', [$validated['tgl_awal'], $validated['tgl_akhir']])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('report.pdf', [
            'peminjaman' => $peminjaman,
            'periode' => $validated['periode'],
            'tgl_awal' => $validated['tgl_awal'],
            'tgl_akhir' => $validated['tgl_akhir'],
        ])->setPaper('a4');

        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }

    public function generateExcel(Request $request)
    {
        $validated = $request->validate([
            'periode' => 'required|in:harian,mingguan,bulanan,tahunan',
            'tgl_awal' => 'required|date',
            'tgl_akhir' => 'required|date|after:tgl_awal',
        ]);

        $peminjaman = Peminjaman::with(['user', 'alat'])
            ->whereBetween('created_at', [$validated['tgl_awal'], $validated['tgl_akhir']])
            ->orderBy('created_at', 'desc')
            ->get();

        return Excel::download(
            new \App\Exports\PeminjamanExport($peminjaman),
            'laporan-peminjaman-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
