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
        Schema::create('electricity_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cost_id');
            $table->string("name")->nullable();
            $table->string("kwh_number")->nullable();
            $table->string("address")->nullable();
            $table->foreign('cost_id')->references('id')->on('costs');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electricity_accounts');
    }
};