<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi tabel users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk menyimpan secret dari two factor authentication
            $table->text('two_factor_secret')
                ->after('password')
                ->nullable();

            // Kolom untuk menyimpan recovery codes dari two factor authentication
            $table->text('two_factor_recovery_codes')
                ->after('two_factor_secret')
                ->nullable();

            // Kolom untuk menyimpan tanggal dan waktu saat two factor authentication di konfirmasi
            $table->timestamp('two_factor_confirmed_at')
                ->after('two_factor_recovery_codes')
                ->nullable();
        });
    }

    /**
     * Membatalkan migrasi tabel users.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom two_factor_secret, two_factor_recovery_codes, dan two_factor_confirmed_at
            $table->dropColumn([
                'two_factor_secret',
                'two_factor_recovery_codes',
                'two_factor_confirmed_at',
            ]);
        });
    }
};

