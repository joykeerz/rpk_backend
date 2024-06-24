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
        Schema::create('produk', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('kategori_id');
            $table->foreignId('pajak_id')->default(0);
            $table->foreignId('satuan_unit_id')->default(0);
            $table->unsignedBigInteger('product_file_id')->nullable();
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->string('desk_produk');
            $table->float('diskon_produk')->default(0);
            $table->unsignedBigInteger('external_produk_id')->nullable();
            $table->string('produk_file_path')->nullable()->default('images/product/default.png');
            $table->timestamps();
            // $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
