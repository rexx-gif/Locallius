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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // kode promo unik
            $table->string('description'); // deskripsi promo
            $table->enum('type', ['percentage', 'fixed']); // tipe diskon: persen atau nominal tetap
            $table->decimal('value', 8, 2); // nilai diskon, contoh: 10.00 (10%) atau 5000.00 (nominal)
            $table->integer('max_uses')->default(1); // maksimal penggunaan promo
            $table->integer('uses')->default(0); // jumlah pemakaian saat ini
            $table->date('valid_until')->nullable(); // tanggal berlaku sampai, nullable artinya bisa tanpa batas waktu
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
