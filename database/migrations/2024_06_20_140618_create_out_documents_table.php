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
        Schema::create('out_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->nullable();
            $table->string('out_document_code')->nullable();
            $table->string('out_document_status')->nullable()->default('draft');
            $table->timestamp('scheduled_date')->nullable();
            $table->string('plat_number')->nullable()->default('none');
            $table->string('driver')->nullable()->default('none');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_documents');
    }
};
