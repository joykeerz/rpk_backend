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
        Schema::table('order_lines', function (Blueprint $table) {
            $table->timestamp('scheduled_date')->nullable();
            $table->string('plat_number')->nullable()->default('none');
            $table->string('driver')->nullable()->default('none');
            $table->integer('ordered_quantity')->nullable()->default(0);
            $table->integer('secondary_quantity')->nullable()->default(0);
            $table->integer('secondary_quantity_done')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_lines', function (Blueprint $table) {
            $table->dropColumn('scheduled_date');
            $table->dropColumn('plat_number');
            $table->dropColumn('driver');
            $table->dropColumn('ordered_quantity');
            $table->dropColumn('secondary_quantity');
            $table->dropColumn('secondary_quantity_done');
        });
    }
};
