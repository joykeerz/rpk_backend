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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('alamat_id');
            $table->unsignedInteger('user_id');
            $table->string('kode_company')->unique();
            $table->string('nama_company');
            $table->string('partner_company');
            $table->string('tagline_company');
            $table->timestamps();
            // $table->foreign('alamat_id')->references('id')->on('alamat')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
