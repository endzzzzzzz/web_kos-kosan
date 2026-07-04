<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('penghuni_id')
                ->constrained('penghunis')
                ->onDelete('cascade');

            $table->string('judul');
            $table->string('kategori');

            $table->text('deskripsi');

            $table->string('lampiran')->nullable();

            $table->enum('status', [
                'pending',
                'diproses',
                'selesai'
            ])->default('pending');

            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};