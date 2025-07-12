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
        Schema::table('reward_redeem_items', function (Blueprint $table) {
            // Pastikan kolom belum ada untuk menghindari error jika migrasi dijalankan ulang
            if (!Schema::hasColumn('reward_redeem_items', 'stock_id')) {
                // Tambahkan kolom stock_id
                // foreignId() secara otomatis membuat UNSIGNED BIGINT dan foreign key constraint
                // ke tabel 'stocks' dan kolom 'id'.
                // onDelete('cascade') artinya jika stock dihapus, item redeem yang terkait juga ikut dihapus.
                $table->foreignId('stock_id')->constrained('stocks')->onDelete('cascade');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reward_redeem_items', function (Blueprint $table) {
            // Pastikan kolom ada sebelum mencoba menghapus foreign key atau kolom
            if (Schema::hasColumn('reward_redeem_items', 'stock_id')) {
                // Hapus foreign key constraint terlebih dahulu
                // dropConstrainedForeignId() adalah metode yang disarankan untuk Laravel 8+
                $table->dropConstrainedForeignId('stock_id');

                // Kemudian, hapus kolom itu sendiri
                $table->dropColumn('stock_id');
            }
        });
    }
};
