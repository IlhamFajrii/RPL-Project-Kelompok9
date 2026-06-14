<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Alat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'alat_id' => Alat::factory(),
            'tanggal_pinjam' => fake()->dateTime(),
            'tanggal_rencana_kembali' => fake()->dateTimeBetween('now', '+7 days'),
            'tanggal_kembali' => null,
            'status_approval' => fake()->randomElement(['pending', 'approved', 'rejected', 'returned']),
            'catatan' => fake()->optional()->sentence(),
            'alasan_reject' => null,
        ];
    }
}
