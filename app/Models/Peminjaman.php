<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $alat_id
 * @property int $jumlah
 * @property Carbon $tanggal_pinjam
 * @property Carbon $tanggal_rencana_kembali
 * @property Carbon|null $tanggal_kembali
 * @property string $status_approval
 * @property string|null $foto_kondisi_awal
 * @property string|null $foto_kondisi_akhir
 * @property string|null $catatan
 * @property string|null $alasan_reject
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'alat_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_rencana_kembali',
        'tanggal_kembali',
        'status_approval',
        'foto_kondisi_awal',
        'foto_kondisi_akhir',
        'catatan',
        'alasan_reject',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_rencana_kembali' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function alat(): BelongsTo
    {
        return $this->belongsTo(Alat::class);
    }

    public function logsNotifikasi(): HasMany
    {
        return $this->hasMany(LogsNotifikasi::class);
    }

    public function isPending(): bool
    {
        return $this->status_approval === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status_approval === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status_approval === 'rejected';
    }

    public function isReturned(): bool
    {
        return $this->status_approval === 'returned';
    }

    public function isLate(): bool
    {
        if ($this->isReturned() && $this->tanggal_kembali) {
            return $this->tanggal_kembali > $this->tanggal_rencana_kembali;
        }
        return now() > $this->tanggal_rencana_kembali && !$this->isReturned();
    }
}
