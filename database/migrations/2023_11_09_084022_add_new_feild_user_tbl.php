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
            $table->tinyInteger('suspend')->default(0);//suspend->1, not-suspend->0
            $table->integer('attempts')->default(0);
            $table->tinyInteger('backlist')->default(0);//backlist->1, not-backlist->0
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('suspend');
            $table->dropColumn('attempts');
            $table->dropColumn('backlist');
        });
    }
};
