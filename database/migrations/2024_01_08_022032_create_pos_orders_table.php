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
        Schema::create('pos_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id');
            $table->string('order_code', 30)->unique();
            $table->string('order_status', 10);
            $table->integer('total_item_qty', 5);
            $table->double('order_subtotal', 10);
            $table->string('extra_note', 180);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_orders');
    }
};
