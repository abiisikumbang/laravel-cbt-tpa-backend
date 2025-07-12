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
            // Tentukan panjang maksimum yang cukup besar untuk string terpanjang Anda
            // 'menunggu konfirmasi' adalah 19 karakter
            // Amankan dengan memberikan ruang lebih, misalnya 50 atau 100
            $table->string('status', 50)->change(); // <--- Ubah panjangnya di sini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reward_redeems', function (Blueprint $table) {
            // Kembalikan ke panjang sebelumnya jika Anda tahu itu dan memang ingin mengembalikannya
            // Atau biarkan saja 50 jika tidak masalah
            // Jika definisi asli adalah string tanpa panjang eksplisit, itu default ke 255
            $table->string('status', 255)->change(); // Contoh: jika awalnya 255
        });
    }
};
