<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreignId('penghuni_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('penghunis')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropForeign(['penghuni_id']);
            $table->dropColumn('penghuni_id');
        });
    }
};