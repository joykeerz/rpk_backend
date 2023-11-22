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
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->string('desk_produk');
            $table->float('diskon_produk')->default(0);
            $table->string('satuan_unit_produk');
            $table->unsignedBigInteger('external_produk_id')->nullable();
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
