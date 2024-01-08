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
        Schema::create('pos_inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_inventory');
            $table->string('kode_transaksi', 120)->unique();
            $table->integer('quantity', 5);
            $table->string('io_status', 15);
            $table->timestamp('io_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_inventory_logs');
    }
};
