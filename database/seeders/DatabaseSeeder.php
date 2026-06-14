<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Alat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::factory()->create([
            'name' => 'Admin SPAL',
            'email' => 'admin@spal.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'nomor_induk' => 'ADM001',
        ]);

        // Create Laboran
        User::factory()->create([
            'name' => 'Laboran',
            'email' => 'laboran@spal.com',
            'password' => bcrypt('password'),
            'role' => 'laboran',
            'nomor_induk' => 'LAB001',
        ]);

        // Create Students/Users
        User::factory(10)->create([
            'role' => 'user',
        ]);

        // Create Alat
        $kategoris = ['Networking', 'Hardware', 'Software', 'Peripheral'];
        
        foreach ($kategoris as $kategori) {
            for ($i = 1; $i <= 5; $i++) {
                Alat::create([
                    'kode_alat' => strtoupper(substr($kategori, 0, 3)) . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama_alat' => $kategori . ' Device ' . $i,
                    'kategori' => $kategori,
                    'deskripsi' => 'Alat untuk praktik ' . $kategori,
                    'status' => 'tersedia',
                    'stok' => 3,
                    'stok_tersedia' => 3,
                ]);
            }
        }
    }
}
