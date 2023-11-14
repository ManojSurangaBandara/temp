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
        Schema::create('bungalow_ranks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bungalow_id')->nullable();
            $table->foreign('bungalow_id')->references('id')->on('bungalows')->onDelete('cascade');
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bungalow_ranks');
    }
};
