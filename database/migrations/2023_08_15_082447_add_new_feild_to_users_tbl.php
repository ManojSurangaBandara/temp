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
            $table->unsignedBigInteger('force_id')->nullable();
            $table->foreign('force_id')->references('id')->on('forces')->onDelete('cascade');
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);//active->1, in-active->0
            $table->string('svc_no')->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('force_id');
            $table->dropColumn('rank_id');
            $table->dropColumn('status');
            $table->dropColumn('svc_no');
        });
    }
};
