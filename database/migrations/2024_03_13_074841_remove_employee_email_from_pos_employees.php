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
        Schema::table('pos_employees', function (Blueprint $table) {
            //
            $table->dropColumn('employee_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_employees', function (Blueprint $table) {
            //
            $table->string('employee_email', 180)->unique();
        });
    }
};
