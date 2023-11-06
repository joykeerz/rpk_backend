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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pesanan_id');
            $table->string('tipe_pembayaran')->nullable();
            $table->string('status_pembayaran')->nullable();
            $table->float('diskon')->nullable();
            $table->float('subtotal_produk')->nullable();
            $table->float('subtotal_pengiriman')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
