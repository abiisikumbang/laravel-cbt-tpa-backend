<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fungsi ini akan menambahkan kolom phone dan roles pada tabel users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom phone
            $table->string('phone')->nullable()->after('email');

            // Menambahkan kolom roles
            $table->string('roles')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Fungsi ini akan menghapus kolom phone dan roles dari tabel users
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom phone dan roles
            $table->dropColumn(['phone' , 'roles']);
        });
    }
};

