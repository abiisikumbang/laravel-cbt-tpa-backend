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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama user
            $table->string('email')->unique(); // email user
            $table->timestamp('email_verified_at')->nullable(); // timestamp ketika email user diverifikasi
            $table->string('password'); // password user
            // $table->foreignId('user_id')->constrained()->onDelete('cascade'); // foreign key ke tabel users
            $table->integer('total_points')->default(0); // total poin yang diperoleh user
            $table->rememberToken(); // token untuk mengingat user
            $table->timestamps(); // timestamp ketika user dibuat dan diupdate
        });

        /**
         * Membuat tabel password_reset_tokens dengan kolom:
         * - email: email user
         * - token: token untuk mengatur ulang password
         * - created_at: timestamp ketika token dibuat
         */
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // email user
            $table->string('token'); // token untuk mengatur ulang password
            $table->timestamp('created_at')->nullable(); // timestamp ketika token dibuat
        });

        /**

         */
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID unik untuk setiap session
            $table->foreignId('user_id')->nullable()->index(); // foreign key ke tabel users
            $table->string('ip_address', 45)->nullable(); // alamat IP user
            $table->text('user_agent')->nullable(); // informasi tentang browser user
            $table->longText('payload'); // data yang disimpan dalam session
            $table->integer('last_activity')->index(); // timestamp ketika session terakhir aktif
        });
    }

    /**
     * Menghapus tabel users, password_reset_tokens, dan sessions
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

