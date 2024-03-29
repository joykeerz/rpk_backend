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
            $table->foreignId('pesanan_id');
            $table->string('tipe_pembayaran')->default('transfer bank');
            $table->string('status_pembayaran')->default('belum dibayar');
            $table->float('diskon')->default(0);
            $table->float('subtotal_produk')->default(0);
            $table->float('subtotal_pengiriman')->default(0);
            $table->float('total_qty')->default(0);
            $table->float('total_pembayaran')->default(0);
            $table->unsignedBigInteger('external_transaksi_id')->nullable();
            $table->timestamps();
            // $table->foreign('pesanan_id')->references('id')->on('pesanan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
