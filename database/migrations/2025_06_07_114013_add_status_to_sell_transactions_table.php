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
        Schema::table('sell_transactions', function (Blueprint $table) {
            $table->enum('status', ['menunggu konfirmasi', 'dijemput', 'diproses', 'selesai'])->default('menunggu konfirmasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sell_transactions', function (Blueprint $table) {
            //
        });
    }
};
