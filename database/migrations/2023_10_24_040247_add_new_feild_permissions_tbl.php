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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('visible_name')->nullable();
            $table->unsignedBigInteger('permission_category_id')->nullable();
            $table->foreign('permission_category_id')->references('id')->on('permission_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('visible_name');
            $table->dropColumn('permission_category_id');
        });
    }
};
