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
        Schema::create('electricity_account_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('electricity_account_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('electricity_account_id')->references('id')->on('electricity_accounts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_account_users');
    }
};
