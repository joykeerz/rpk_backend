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
        Schema::create('pos_sessions', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('employee_id');
            $table->foreignId('profile_id');
            $table->string('employee_name', 30);
            $table->double('balance');
            $table->double('opening_cash');
            $table->double('closing_cash');
            $table->timestamp('session_start');
            $table->timestamp('session_end');
            $table->string('session_notes', 180)->nullable()->default('tidak ada catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_sessions');
    }
};
