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
        Schema::table('users', function (Blueprint $table) {
            // Ubah enum role menjadi customer & admin
            $table->enum('role', ['customer', 'admin'])->default('customer')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan ke enum sebelumnya (user & admin)
            $table->enum('role', ['user', 'admin'])->default('user')->change();
        });
    }
};
