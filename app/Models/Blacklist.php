<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $alasan
 * @property \Illuminate\Support\Carbon $tanggal_mulai
 * @property \Illuminate\Support\Carbon|null $tanggal_berakhir
 * @property bool $aktif
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Blacklist extends Model
{
    use HasFactory;

    protected $table = 'blacklist';

    protected $fillable = [
        'user_id',
        'alasan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_berakhir' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        if (!$this->aktif) {
            return false;
        }

        if ($this->tanggal_berakhir === null) {
            return true;
        }

        return now() < $this->tanggal_berakhir;
    }
}
