<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string $nomor_induk
 * @property string|null $no_telepon
 * @property string|null $alamat
 * @property string $role
 * @property bool $status_blacklist
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
#[Fillable(['name', 'email', 'password', 'nomor_induk', 'no_telepon', 'alamat', 'role', 'status_blacklist'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function blacklist(): HasMany
    {
        return $this->hasMany(Blacklist::class);
    }

    public function logsNotifikasi(): HasMany
    {
        return $this->hasMany(LogsNotifikasi::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isLaboran(): bool
    {
        return $this->role === 'laboran';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isBlacklisted(): bool
    {
        // Check dari database blacklist table secara realtime
        return Blacklist::where('user_id', $this->id)
                       ->where('aktif', true)
                       ->exists();
    }
}
