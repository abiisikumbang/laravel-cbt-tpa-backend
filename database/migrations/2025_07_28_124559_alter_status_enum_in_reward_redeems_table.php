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
         DB::statement("ALTER TABLE reward_redeems MODIFY status
            ENUM('menunggu konfirmasi', 'diantar', 'diproses', 'selesai', 'batal')
            NOT NULL DEFAULT 'menunggu konfirmasi'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE reward_redeems MODIFY status
            ENUM('menunggu konfirmasi', 'diantar', 'diproses', 'selesai')
            NOT NULL DEFAULT 'menunggu konfirmasi'");
    }
};
