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
        Schema::create('stok', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('produk_id');
            $table->unsignedInteger('gudang_id');
            $table->float('jumlah_stok');
            $table->float('harga_stok');
            $table->unsignedBigInteger('external_stok_id')->nullable();
            $table->timestamps();
            // $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
            // $table->foreign('gudang_id')->references('id')->on('gudang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
