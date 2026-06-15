<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::query();

        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%')
                ->orWhere('kode_alat', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $alat = $query->paginate(12);
        $kategoris = Alat::distinct('kategori')->pluck('kategori');

        return view('alat.index', compact('alat', 'kategoris'));
    }

    public function show(Alat $alat)
    {
        $alat->load(['peminjaman' => function ($query) {
            $query->where('status_approval', 'approved')->whereNull('tanggal_kembali');
        }]);

        return view('alat.show', compact('alat'));
    }

    public function create()
    {
        return view('alat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_alat' => 'required|unique:alat',
            'nama_alat' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok' => 'required|integer|min:1',
            'stok_tersedia' => 'nullable|integer|min:0',
        ]);

        // Validasi: stok_tersedia tidak boleh lebih besar dari stok
        if (isset($validated['stok_tersedia']) && $validated['stok_tersedia'] > $validated['stok']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok Tersedia tidak boleh lebih besar dari Stok Total');
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $validated['status'] = 'tersedia';
        // Jika stok_tersedia tidak diinput, gunakan nilai stok
        $validated['stok_tersedia'] = $validated['stok_tersedia'] ?? $validated['stok'];

        Alat::create($validated);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan');
    }

    public function edit(Alat $alat)
    {
        return view('alat.edit', compact('alat'));
    }

    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'kode_alat' => 'required|unique:alat,kode_alat,' . $alat->id,
            'nama_alat' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:tersedia,dipinjam,rusak,maintenance',
            'stok' => 'required|integer|min:1',
            'stok_tersedia' => 'nullable|integer|min:0',
        ]);

        // Validasi: stok_tersedia tidak boleh lebih besar dari stok
        if (isset($validated['stok_tersedia']) && $validated['stok_tersedia'] > $validated['stok']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok Tersedia tidak boleh lebih besar dari Stok Total');
        }

        if ($request->hasFile('foto')) {
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        // Always recalculate stok_tersedia based on actual borrowed items
        $borrowedCount = $alat->peminjaman()
            ->where('status_approval', 'approved')
            ->whereNull('tanggal_kembali')
            ->sum('jumlah');
        
        // Calculate stok_tersedia = new stok - borrowed items
        $validated['stok_tersedia'] = $validated['stok'] - $borrowedCount;

        $alat->update($validated);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil diperbarui');
    }

    public function destroy(Alat $alat)
    {
        if ($alat->foto) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Alat berhasil dihapus');
    }
}
