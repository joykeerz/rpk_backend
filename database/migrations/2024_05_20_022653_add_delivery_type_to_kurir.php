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
        Schema::table('kurir', function (Blueprint $table) {
            $table->foreignId('company_id')->default(1);
            $table->string('delivery_type')->default('fixed');
            $table->integer('fixed_price')->default(0);
            $table->text('description')->default('kosong');
            $table->double('margin_percentage')->default(0);
            $table->string('image_filepath')->nullable()->default();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kurir', function (Blueprint $table) {
            $table->foreignId('company_id');
            $table->dropColumn('delivery_type');
            $table->dropColumn('fixed_price');
            $table->dropColumn('description');
            $table->dropColumn('margin_percentage');
            $table->dropColumn('image_filepath');
            $table->dropSoftDeletes();
        });
    }
};
