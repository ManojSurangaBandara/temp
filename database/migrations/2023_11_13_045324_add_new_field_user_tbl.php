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
        Schema::table('users', function (Blueprint $table) {            
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade');
            $table->unsignedBigInteger('regiment_id')->nullable();
            $table->foreign('regiment_id')->references('id')->on('regiments')->onDelete('cascade');
            $table->unsignedBigInteger('directorate_id')->nullable();
            $table->foreign('directorate_id')->references('id')->on('directorates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {            
            $table->dropColumn('rank_id');
            $table->dropColumn('regiment_id');
            $table->dropColumn('directorate_id');
        });
    }
};
