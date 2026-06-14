<?php

namespace Database\Factories;

use App\Models\Alat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Alat>
 */
class AlatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_alat' => 'ALT-' . fake()->unique()->numerify('####'),
            'nama_alat' => fake()->words(3, true),
            'kategori' => fake()->randomElement(['Elektronik', 'Mekanik', 'Kimia', 'Biologi', 'Fisika']),
            'deskripsi' => fake()->sentence(),
            'status' => fake()->randomElement(['tersedia', 'rusak', 'maintenance']),
            'stok' => fake()->numberBetween(1, 50),
            'stok_tersedia' => fake()->numberBetween(0, 50),
        ];
    }
}
