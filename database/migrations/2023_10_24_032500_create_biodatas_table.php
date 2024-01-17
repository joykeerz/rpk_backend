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
        Schema::create('biodata', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('id')->primary();
            $table->foreignId('user_id');
            $table->foreignId('alamat_id')->default(1);
            $table->string('kode_customer')->nullable();
            $table->string('nama_rpk')->default('none');
            $table->string('no_ktp')->default('none');
            $table->string('ktp_img')->nullable();
            $table->unsignedBigInteger('external_biodata_id')->nullable();
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('alamat_id')->references('id')->on('alamat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biodata');
    }
};
