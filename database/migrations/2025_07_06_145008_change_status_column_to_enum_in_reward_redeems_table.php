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
        Schema::table('reward_redeems', function (Blueprint $table) {
            $table->enum('status', ['menunggu konfirmasi', 'diantar', 'diproses', 'selesai'])
                  ->default('menunggu konfirmasi')
                  ->change(); // Menggunakan .change() untuk memodifikasi kolom yang sudah ada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('reward_redeems', function (Blueprint $table) {
            $table->string('status', 255)->default('pending')->change(); // Asumsi default aslinya 'pending'
        });
    }
};
