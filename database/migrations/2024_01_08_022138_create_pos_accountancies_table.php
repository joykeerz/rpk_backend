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
        Schema::create('pos_accountancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id');
            $table->string('accountancy_name', 30)->nullable()->default();
            $table->string('transaction_type', 10);
            $table->double('transaction_amount', 10);
            $table->string('extra_note', 180)->nullable()->default('tidak ada catatan');
            $table->text('attachment_image', 180)->nullable()->default('default.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_accountancies');
    }
};
