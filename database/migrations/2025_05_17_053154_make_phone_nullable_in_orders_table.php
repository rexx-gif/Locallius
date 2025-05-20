<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;  // import DB di sini

return new class extends Migration
{
    public function up()
    {
        // Ubah semua NULL jadi string kosong biar bisa diubah ke NOT NULL
        DB::table('orders')->whereNull('phone')->update(['phone' => '-']);

        Schema::table('orders', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->change(); // NOT NULL
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('phone')->nullable(true)->change(); // Kembalikan jadi nullable
        });
    }
};
