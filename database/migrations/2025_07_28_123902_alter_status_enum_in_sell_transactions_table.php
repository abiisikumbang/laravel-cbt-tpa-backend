<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         DB::statement("ALTER TABLE sell_transactions MODIFY status
            ENUM('menunggu konfirmasi', 'dijemput', 'diproses', 'selesai', 'batal')
            DEFAULT 'menunggu konfirmasi'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE sell_transactions MODIFY status
            ENUM('menunggu konfirmasi', 'dijemput', 'diproses', 'selesai')
            DEFAULT 'menunggu konfirmasi'");
    }
};
