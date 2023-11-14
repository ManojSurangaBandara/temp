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
        Schema::create('bungalows', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->tinyInteger('status')->default(1);//active->1, in-active->0
            $table->integer('no_ac_room');
            $table->integer('no_none_ac_room');
            $table->integer('no_guest');
            $table->decimal('serving_price',8,2);
            $table->decimal('retired_price',8,2);
            $table->decimal('death_price',8,2);
            $table->unsignedBigInteger('directorate_id')->nullable();
            $table->foreign('directorate_id')->references('id')->on('directorates')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bungalows');
    }
};
