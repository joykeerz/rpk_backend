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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('stok_id');
            $table->foreignId('gudang_id');
            $table->string('wishlist_group')->default('none');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('stok_id')->references('id')->on('stok')->onDelete('cascade');
            // $table->foreign('gudang_id')->references('id')->on('gudang')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
