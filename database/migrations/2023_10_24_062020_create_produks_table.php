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
            $table->id();
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('pajak_id')->default(0);
            $table->unsignedInteger('satuan_unit_id')->default(0);
            $table->unsignedBigInteger('product_file_id')->nullable();
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->string('desk_produk');
            $table->float('diskon_produk')->default(0);
            $table->unsignedBigInteger('external_produk_id')->nullable();
            $table->string('produk_file_path')->nullable();
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
