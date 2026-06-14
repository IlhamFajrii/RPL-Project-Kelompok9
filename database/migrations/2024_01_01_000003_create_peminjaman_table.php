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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alat')->onDelete('cascade');
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_rencana_kembali');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->enum('status_approval', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
            $table->string('foto_kondisi_awal')->nullable();
            $table->string('foto_kondisi_akhir')->nullable();
            $table->text('catatan')->nullable();
            $table->text('alasan_reject')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
