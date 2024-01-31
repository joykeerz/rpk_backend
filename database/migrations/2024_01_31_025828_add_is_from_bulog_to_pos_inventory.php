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
        Schema::table('pos_inventories', function (Blueprint $table) {
            //
            $table->boolean('is_from_bulog')->default(false)->after('pos_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_inventories', function (Blueprint $table) {
            //
            $table->dropColumn('is_from_bulog');
        });
    }
};
