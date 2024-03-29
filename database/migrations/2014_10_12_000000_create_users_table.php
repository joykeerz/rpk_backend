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
        Schema::create('users', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('role_id')->default(1);
            $table->foreignId('company_id')->nullable()->default(1);
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('no_hp');
            $table->string('password');
            $table->integer('isVerified')->default(0);
            $table->unsignedBigInteger('external_user_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            // $table->unsignedBigInteger('created_by')->nullable();
            // $table->unsignedBigInteger('updated_by')->nullable();
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
