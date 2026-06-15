<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Blacklist;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        if ($request->filled('status')) {
            $query->where('status_approval', $request->status);
        }

        $peminjaman = $query->latest()->paginate(10);
        $statuses = ['pending', 'approved', 'rejected', 'returned'];

        return view('approval.index', compact('peminjaman', 'statuses'));
    }

    public function show(Peminjaman $peminjaman)
    {
        return view('approval.show', compact('peminjaman'));
    }

    public function approve(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status_approval !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses');
        }

        $peminjaman->update([
            'status_approval' => 'approved',
        ]);

        // Update alat stock based on jumlah
        $peminjaman->alat->decrement('stok_tersedia', $peminjaman->jumlah);

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui');
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'alasan_reject' => 'required',
        ]);

        if ($peminjaman->status_approval !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses');
        }

        $peminjaman->update([
            'status_approval' => 'rejected',
            'alasan_reject' => $validated['alasan_reject'],
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak');
    }

    public function processReturn(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'tanggal_kembali' => 'required|date',
            'catatan' => 'nullable',
        ]);

        $peminjaman->update([
            'status_approval' => 'returned',
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        // Update alat stock based on jumlah
        $peminjaman->alat->increment('stok_tersedia', $peminjaman->jumlah);

        // Check if late and damaged
        $isLate = \Carbon\Carbon::parse($validated['tanggal_kembali']) > $peminjaman->tanggal_rencana_kembali;

        if ($isLate) {
            $lateCount = $peminjaman->user->peminjaman()
                ->where('status_approval', 'returned')
                ->whereRaw('tanggal_kembali > tanggal_rencana_kembali')
                ->count();

            if ($lateCount >= 3) {
                Blacklist::create([
                    'user_id' => $peminjaman->user_id,
                    'alasan' => 'Peminjaman terlambat lebih dari 3 kali',
                    'tanggal_mulai' => now(),
                    'tanggal_berakhir' => now()->addDays(30),
                    'aktif' => true,
                ]);

                $peminjaman->user->update(['status_blacklist' => true]);
            }
        }

        return redirect()->back()->with('success', 'Pengembalian alat berhasil diproses');
    }
}
