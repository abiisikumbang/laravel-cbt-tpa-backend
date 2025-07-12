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
            // MySQL specific: mengubah tipe kolom dari string/varchar ke enum.
            // Penting: pastikan semua nilai yang sudah ada di kolom 'status'
            // cocok dengan salah satu nilai di array ENUM yang baru.
            // Karena Anda sudah menjalankan migrasi pengubah nama nilai status,
            // seharusnya ini aman.
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
            // Mengembalikan kolom ke tipe string (misalnya VARCHAR(255))
            // Ini adalah default Laravel jika Anda tidak menentukan panjang.
            // Jika Anda tahu panjang aslinya, gunakan itu.
            $table->string('status', 255)->default('pending')->change(); // Asumsi default aslinya 'pending'
        });
    }
};
