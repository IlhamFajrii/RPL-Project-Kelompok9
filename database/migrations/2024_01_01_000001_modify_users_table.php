<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'laboran', 'user'])->default('user')->after('password');
            $table->boolean('status_blacklist')->default(false)->after('role');
            $table->string('nomor_induk')->nullable()->after('email')->comment('NIP/NISN');
            $table->string('no_telepon')->nullable()->after('nomor_induk');
            $table->text('alamat')->nullable()->after('no_telepon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status_blacklist', 'nomor_induk', 'no_telepon', 'alamat']);
        });
    }
};
