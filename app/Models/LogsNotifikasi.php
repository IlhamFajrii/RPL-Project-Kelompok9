<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogsNotifikasi extends Model
{
    use HasFactory;

    protected $table = 'logs_notifikasi';

    protected $fillable = [
        'user_id',
        'pesan',
        'status',
        'tipe',
        'peminjaman_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
