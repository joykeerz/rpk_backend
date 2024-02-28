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
        Schema::create('pos_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('payment_method_id');
            $table->foreignId('promo_id');
            $table->string('transaction_code');
            $table->string('payment_status', 10);
            $table->double('grand_total');
            $table->double('paid_amount');
            $table->double('change_amount');
            $table->timestamp('paid_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_sales');
    }
};
