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
        Schema::create('satuan_unit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_satuan_unit_id')->nullable();
            $table->string('nama_satuan');
            $table->string('satuan_unit_produk ');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satuan_units');
    }
};
