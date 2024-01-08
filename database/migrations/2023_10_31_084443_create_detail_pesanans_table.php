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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id');
            $table->foreignId('produk_id');
            $table->float('qty');
            $table->float('harga');
            $table->unsignedBigInteger('external_detail_pesanan_id')->nullable();
            $table->timestamps();
            // $table->foreign('pesanan_id')->reference('id')->on('pesanan')->onDelete('cascade');
            // $table->foreign('produk_id')->reference('id')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
