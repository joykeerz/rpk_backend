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
        Schema::create('gudang', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('alamat_id');
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('user_id');
            $table->string('nama_gudang');
            $table->string('no_telp');
            $table->unsignedBigInteger('external_gudang_id')->nullable();
            $table->timestamps();
            // $table->foreign('alamat_id')->references('id)->on('alamat')->onDelete('cascade');
            // $table->foreign('company_id')->references('id)->on('companies')->onDelete('cascade');
            // $table->foreign('user_id')->references('id)->on('users')->onDelete('cascade'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang');
    }
};
