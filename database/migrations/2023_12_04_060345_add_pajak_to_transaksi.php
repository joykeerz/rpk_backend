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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->float('total_dpp')->default(0);
            $table->float('total_ppn')->default(0);
            $table->float('dpp_terutang')->default(0);
            $table->float('ppn_terutang')->default(0);
            $table->float('dpp_dibebaskan')->default(0);
            $table->float('ppn_dibebaskan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            //
            $table->dropColumn('total_dpp');
            $table->dropColumn('total_ppn');
            $table->dropColumn('dpp_terutang');
            $table->dropColumn('ppn_terutang');
            $table->dropColumn('dpp_dibebaskan');
            $table->dropColumn('ppn_dibebaskan');
        });
    }
};
