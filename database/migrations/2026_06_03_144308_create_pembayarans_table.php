<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {

            $table->id();

            // relasi ke user (LOGIN SYSTEM)
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // relasi ke pengajuan booking
            $table->foreignId('pengajuan_id')
                ->constrained('pengajuans')
                ->onDelete('cascade');

            $table->string('bulan')->nullable();
            $table->year('tahun')->nullable();

            $table->integer('nominal');

            $table->string('metode_pembayaran')->nullable();
            $table->string('bukti_transfer')->nullable();

            $table->enum('status', [
                'belum_bayar',
                'pending',
                'lunas',
                'ditolak'
            ])->default('belum_bayar');

            $table->date('tanggal_bayar')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};