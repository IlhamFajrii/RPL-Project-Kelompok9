<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix any stok_tersedia that is greater than stok
        // Set stok_tersedia to match stok if it exceeds it
        DB::table('alat')
            ->whereRaw('stok_tersedia > stok')
            ->update([
                'stok_tersedia' => DB::raw('stok')
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We can't accurately revert this, so we do nothing
    }
};
