<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Peminjaman::with(['alat']);

        if ($user && $user->isUser()) {
            $query->where('user_id', $user->id);
        }

        $peminjaman = $query->latest()->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create(Alat $alat)
    {
        if ($alat->stok_tersedia <= 0) {
            return redirect()->back()
                ->with('error', 'Alat tidak tersedia');
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user && $user->isBlacklisted()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat meminjam alat karena masuk blacklist');
        }

        return view('peminjaman.create', compact('alat'));
    }

    public function store(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $alat->stok_tersedia,
            'tanggal_rencana_kembali' => 'required|date|after:now',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($user && $user->isBlacklisted()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat meminjam alat karena masuk blacklist');
        }

        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'alat_id' => $alat->id,
            'jumlah' => $validated['jumlah'],
            'tanggal_pinjam' => now(),
            'tanggal_rencana_kembali' => $validated['tanggal_rencana_kembali'],
            'status_approval' => 'pending',
        ]);

        return redirect()
            ->route('peminjaman.show', $peminjaman)
            ->with('success', 'Pengajuan peminjaman berhasil dibuat');
    }

    public function show(Peminjaman $peminjaman)
    {
        $this->authorize('view', $peminjaman);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function uploadFotoKondisiAwal(Request $request, Peminjaman $peminjaman)
    {
        $this->authorize('view', $peminjaman);

        $request->validate([
            'foto_kondisi_awal' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($peminjaman->foto_kondisi_awal) {
            Storage::disk('public')->delete($peminjaman->foto_kondisi_awal);
        }

        $path = $request->file('foto_kondisi_awal')
            ->store('peminjaman', 'public');

        $peminjaman->update([
            'foto_kondisi_awal' => $path,
        ]);

        return back()->with(
            'success',
            'Foto kondisi awal berhasil diunggah'
        );
    }

    public function uploadFotoKondisiAkhir(Request $request, Peminjaman $peminjaman)
    {
        $this->authorize('view', $peminjaman);

        $request->validate([
            'foto_kondisi_akhir' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($peminjaman->foto_kondisi_akhir) {
            Storage::disk('public')->delete($peminjaman->foto_kondisi_akhir);
        }

        $path = $request->file('foto_kondisi_akhir')
            ->store('peminjaman', 'public');

        $peminjaman->update([
            'foto_kondisi_akhir' => $path,
        ]);

        return back()->with(
            'success',
            'Foto kondisi akhir berhasil diunggah'
        );
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $this->authorize('delete', $peminjaman);

        if ($peminjaman->status_approval !== 'pending') {
            return redirect()->back()
                ->with(
                    'error',
                    'Hanya peminjaman dengan status pending yang dapat dihapus'
                );
        }

        $peminjaman->delete();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dihapus');
    }
}