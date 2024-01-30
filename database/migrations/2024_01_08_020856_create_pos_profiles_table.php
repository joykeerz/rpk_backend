<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('pos_name', 30);
            $table->string('pin')->nullable()->default(Hash::make('000000'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_profiles');
    }
};
