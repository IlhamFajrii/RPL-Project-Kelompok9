<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $kode_alat
 * @property string $nama_alat
 * @property string $kategori
 * @property string|null $deskripsi
 * @property string|null $foto
 * @property string|null $qr_code
 * @property string $status
 * @property int $stok
 * @property int $stok_tersedia
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
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
