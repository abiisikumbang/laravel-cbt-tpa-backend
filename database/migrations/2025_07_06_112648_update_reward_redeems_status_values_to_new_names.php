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
        // Perbarui nilai status lama ke nilai baru
        DB::table('reward_redeems')->where('status', 'pending')->update(['status' => 'menunggu konfirmasi']);
        DB::table('reward_redeems')->where('status', 'approved')->update(['status' => 'diantar']); // Asumsi 'approved' menjadi 'diantar'
        DB::table('reward_redeems')->where('status', 'delivered')->update(['status' => 'selesai']); // Asumsi 'delivered' menjadi 'selesai'
        DB::table('reward_redeems')->where('status', 'rejected')->update(['status' => 'diproses']); // Asumsi 'rejected' menjadi 'diproses'
        // Sesuaikan mapping di atas jika "diantar" atau "diproses" bukan padanan yang tepat untuk "approved" dan "rejected".
        // Jika Anda tidak memiliki padanan untuk 'rejected' (misal: 'Dibatalkan'), sesuaikan juga.
        // Contoh: DB::table('reward_redeems')->where('status', 'rejected')->update(['status' => 'dibatalkan']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan nilai status baru ke nilai lama
        // Ini penting untuk fungsi rollback migrasi
        DB::table('reward_redeems')->where('status', 'menunggu konfirmasi')->update(['status' => 'pending']);
        DB::table('reward_redeems')->where('status', 'diantar')->update(['status' => 'approved']);
        DB::table('reward_redeems')->where('status', 'selesai')->update(['status' => 'delivered']);
        DB::table('reward_redeems')->where('status', 'diproses')->update(['status' => 'rejected']);
        // Pastikan mapping di sini adalah kebalikan dari yang ada di metode up()
    }
};
