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
        Schema::table('pos_payment_methods', function (Blueprint $table) {
            //
            $table->string('payment_type')->nullable()->default('tunai');
            $table->text('payment_file')->nullable()->default('default.jpg');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_payment_methods', function (Blueprint $table) {
            //
            $table->dropColumn('payment_type');
            $table->dropColumn('payment_file');
        });
    }
};
