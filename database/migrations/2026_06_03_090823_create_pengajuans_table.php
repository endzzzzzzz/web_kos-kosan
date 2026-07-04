<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();

            // siapa yang mengajukan (kalau sudah pakai login)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // kamar yang dipilih
            $table->foreignId('kamar_id')
                ->constrained('kamars')
                ->cascadeOnDelete();

            // data diri (snapshot saat booking)
            $table->string('nama');
            $table->string('no_hp');
            $table->text('alamat')->nullable();

            // status proses
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            // opsional: tanggal rencana masuk
            $table->date('tanggal_rencana_masuk')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};