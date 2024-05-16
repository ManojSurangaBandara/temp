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
        Schema::create('calendareligibilty', function (Blueprint $table) {
            $table->id();
            $table->integer('no_of_days');
            $table->tinyInteger('active');//serving->0, retired->1, official->2
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendareligibilty');
    }
};
