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
            $table->string('transaction_code', 30);
            $table->string('payment_status', 10);
            $table->float('discount', 3)->nullable()->default(0);
            $table->float('discount_value', 10)->nullable()->default(0);
            $table->double('grand_total', 10);
            $table->double('paid_amount', 10);
            $table->double('change_amount', 10);
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
