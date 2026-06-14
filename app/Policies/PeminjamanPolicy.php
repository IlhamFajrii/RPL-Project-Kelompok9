<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Peminjaman;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        return $user->id === $peminjaman->user_id || $user->isAdmin() || $user->isLaboran();
    }

    public function update(User $user, Peminjaman $peminjaman): bool
    {
        return $user->id === $peminjaman->user_id && $peminjaman->status_approval === 'pending';
    }

    public function delete(User $user, Peminjaman $peminjaman): bool
    {
        return $user->id === $peminjaman->user_id && $peminjaman->status_approval === 'pending';
    }
}
