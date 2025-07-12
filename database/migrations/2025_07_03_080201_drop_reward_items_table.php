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
        if (Schema::hasColumn('reward_redeem_items', 'reward_item_id')) {
            Schema::table('reward_redeem_items', function (Blueprint $table) {
                $table->dropConstrainedForeignId('reward_item_id');
            });
        }

                // 2. Hapus Kolom 'reward_item_id' dari 'reward_redeem_items' (Opsional tapi Disarankan)
        // Lakukan ini jika kolom 'reward_item_id' di tabel pivot memang tidak lagi dibutuhkan
        if (Schema::hasColumn('reward_redeem_items', 'reward_item_id')) {
             Schema::table('reward_redeem_items', function (Blueprint $table) {
                 $table->dropColumn('reward_item_id');
             });
        }


        // 3. Hapus Tabel 'reward_items'
        // Pastikan ini adalah langkah terakhir di metode up() untuk penghapusan tabel
        if (Schema::hasTable('reward_items')) {
            Schema::drop('reward_items');
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    // 1. Buat ulang tabel 'reward_items'
        // Salin definisi asli dari migrasi 'create_reward_items_table'
        Schema::create('reward_items', function (Blueprint $table) {
            $table->id(); // Atau $table->id('reward_item_id'); jika itu nama kolomnya
            $table->string('name');
            $table->integer('point_cost');
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // 2. Tambahkan kembali kolom 'reward_item_id' ke 'reward_redeem_items'
        // dan foreign key constraint ke 'reward_items'
        Schema::table('reward_redeem_items', function (Blueprint $table) {
            // Jika Anda menghapus kolom di up(), buat kembali di down()
            // Pastikan tipe data sesuai dengan primary key di reward_items
            $table->unsignedBigInteger('reward_item_id')->nullable(); // Pastikan nullable jika itu kasusnya
            // Tambahkan kembali foreign key constraint
            $table->foreign('reward_item_id')
                  ->references('id') // Atau 'reward_item_id' jika itu nama primary key di reward_items
                  ->on('reward_items')
                  ->onDelete('cascade'); // Sesuaikan onDelete dengan definisi asli Anda
        });
    }
};
