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
        Schema::create('informasi_kamars', function (Blueprint $table) {
            $table->id();

            $table->string('nama_kamar');
            $table->string('slug')->unique();

            $table->string('lantai');

            $table->integer('harga');

            $table->text('deskripsi')->nullable();

            $table->boolean('wifi')->default(false);
            $table->boolean('kamar_mandi_dalam')->default(false);
            $table->boolean('ac')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_kamars');
    }
};