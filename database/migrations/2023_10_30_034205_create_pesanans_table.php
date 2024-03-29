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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('alamat_id');
            $table->foreignId('kurir_id');
            $table->string('status_pemesanan')->default('diproses');
            $table->unsignedBigInteger('external_pesanan_id')->nullable();
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('alamat_id')->references('id')->on('alamat')->onDelete('cascade');
            // $table->foreign('kurir_id')->references('id')->on('kurir')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
