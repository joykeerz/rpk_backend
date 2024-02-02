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
        //
        Schema::create('locations', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('gudang_id');
            $table->string('location_name', 180);
            $table->string('parent_location', 180)->nullable()->default('(blank)');
            $table->string('unique_or_many', 180)->default('many_product');
            $table->unsignedBigInteger('external_location_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('locations');
    }
};
