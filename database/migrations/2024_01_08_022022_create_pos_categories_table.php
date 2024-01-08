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
        Schema::create('pos_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id');
            $table->string('category_name', 30);
            $table->string('category_desc', 180)->nullable()->default('tidak ada deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_categories');
    }
};
