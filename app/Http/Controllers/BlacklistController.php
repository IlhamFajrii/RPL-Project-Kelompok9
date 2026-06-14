<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\User;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function index(Request $request)
    {
        $query = Blacklist::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nomor_induk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('aktif', true);
            } elseif ($request->status === 'expired') {
                $query->where('aktif', false)
                      ->orWhere('tanggal_berakhir', '<', now());
            }
        }

        $blacklist = $query->latest()->paginate(10);

        return view('blacklist.index', compact('blacklist'));
    }

    public function create()
    {
        $users = User::where('role', 'user')
                     ->orderBy('name')
                     ->get();

        return view('blacklist.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'alasan' => 'required|min:10',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after:tanggal_mulai',
            'aktif' => 'boolean',
        ], [
            'user_id.required' => 'User harus dipilih',
            'user_id.exists' => 'User tidak ditemukan',
            'alasan.required' => 'Alasan blacklist harus diisi',
            'alasan.min' => 'Alasan minimal 10 karakter',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
            'tanggal_berakhir.after' => 'Tanggal berakhir harus setelah tanggal mulai',
        ]);

        // Set default value untuk aktif jika tidak ada
        $validated['aktif'] = $request->has('aktif');

        // Cek apakah user sudah di-blacklist
        $existingBlacklist = Blacklist::where('user_id', $validated['user_id'])
                                       ->where('aktif', true)
                                       ->first();

        if ($existingBlacklist) {
            return redirect()->back()
                           ->with('error', 'User ini sudah dalam status blacklist');
        }

        Blacklist::create($validated);

        // Update status_blacklist di user
        User::find($validated['user_id'])->update(['status_blacklist' => true]);

        return redirect()->route('blacklist.index')
                       ->with('success', 'User berhasil ditambahkan ke blacklist');
    }

    public function edit(Blacklist $blacklist)
    {
        return view('blacklist.edit', compact('blacklist'));
    }

    public function update(Request $request, Blacklist $blacklist)
    {
        $validated = $request->validate([
            'alasan' => 'required|min:10',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'nullable|date|after:tanggal_mulai',
            'aktif' => 'boolean',
        ], [
            'alasan.required' => 'Alasan blacklist harus diisi',
            'alasan.min' => 'Alasan minimal 10 karakter',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
            'tanggal_berakhir.after' => 'Tanggal berakhir harus setelah tanggal mulai',
        ]);

        // Set default value untuk aktif jika tidak ada
        $validated['aktif'] = $request->has('aktif');

        $blacklist->update($validated);

        // Update status user jika diaktifkan/dinonaktifkan
        if ($validated['aktif'] && !$blacklist->user->isBlacklisted()) {
            $blacklist->user->update(['status_blacklist' => true]);
        } elseif (!$validated['aktif']) {
            // Cek apakah ada blacklist lain yang aktif
            $otherBlacklist = Blacklist::where('user_id', $blacklist->user_id)
                                       ->where('id', '!=', $blacklist->id)
                                       ->where('aktif', true)
                                       ->exists();

            if (!$otherBlacklist) {
                $blacklist->user->update(['status_blacklist' => false]);
            }
        }

        return redirect()->route('blacklist.index')
                       ->with('success', 'Data blacklist berhasil diperbarui');
    }

    public function destroy(Blacklist $blacklist)
    {
        $user = $blacklist->user;
        $blacklist->delete();

        // Cek apakah ada blacklist lain yang aktif untuk user ini
        $otherBlacklist = Blacklist::where('user_id', $user->id)
                                    ->where('aktif', true)
                                    ->exists();

        if (!$otherBlacklist) {
            $user->update(['status_blacklist' => false]);
        }

        return redirect()->route('blacklist.index')
                       ->with('success', 'Data blacklist berhasil dihapus');
    }

    public function removeExpired()
    {
        $expiredBlacklists = Blacklist::where('tanggal_berakhir', '<', now())
                                       ->where('aktif', true)
                                       ->get();

        foreach ($expiredBlacklists as $blacklist) {
            $blacklist->update(['aktif' => false]);

            // Cek apakah ada blacklist lain yang aktif
            $otherBlacklist = Blacklist::where('user_id', $blacklist->user_id)
                                       ->where('aktif', true)
                                       ->exists();

            if (!$otherBlacklist) {
                $blacklist->user->update(['status_blacklist' => false]);
            }
        }

        return redirect()->back()
                       ->with('success', 'Blacklist yang sudah expired telah diupdate');
    }
}
