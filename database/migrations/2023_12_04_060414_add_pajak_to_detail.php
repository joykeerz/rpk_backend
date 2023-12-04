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
        Schema::table('detail_pesanan', function (Blueprint $table) {
            //
            $table->float('dpp')->default(0);
            $table->float('ppn')->default(0);
            $table->string('jenis_pajak')->nullable();
            $table->float('persentase_pajak')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            //
            $table->dropColumn('dpp');
            $table->dropColumn('ppn');
            $table->dropColumn('jenis_pajak');
            $table->dropColumn('persentase_pajak');
        });
    }
};
