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
        Schema::create('electricity_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('electricity_account_id');
            $table->integer('month');
            $table->integer("year");
            $table->integer("meter_from")->nullable();
            $table->integer("meter_to")->nullable();
            $table->foreign('electricity_account_id')->references('id')->on('electricity_accounts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_usages');
    }
};
