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
        Schema::create('pos_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id');
            $table->integer('pin');
            $table->string('employee_email', 180)->unique();
            $table->string('employee_name', 30);
            $table->string('employee_phone', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_employees');
    }
};
