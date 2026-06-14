<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alat';

    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'kategori',
        'deskripsi',
        'foto',
        'qr_code',
        'status',
        'stok',
        'stok_tersedia',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'tersedia' && $this->stok_tersedia > 0;
    }

    public function getTotalPeminjamanAttribute()
    {
        return $this->peminjaman()
            ->whereIn('status_approval', ['pending', 'approved'])
            ->count();
    }
}
