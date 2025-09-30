<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            // ubah kolom status agar default "diproses"
            $table->string('status')->default('diproses')->change();
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            // rollback: hilangkan default value
            $table->string('status')->nullable()->change();
        });
    }
};
