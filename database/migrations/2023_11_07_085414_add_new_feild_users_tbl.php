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
            $table->string('last_login_ip',15)->nullable();
            $table->date('last_login_date')->nullable();           
            $table->string('mobile_no')->unique()->nullable();
            $table->string('svc_no')->unique()->nullable();
            $table->string('username')->unique()->nullable();
            // $table->unsignedBigInteger('rank_id')->nullable();
            // $table->unsignedBigInteger('regiment_id')->nullable();
            // $table->unsignedBigInteger('location_id')->nullable();
            $table->tinyInteger('status')->default(1);//active->1, in-active->0
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login_ip');
            $table->dropColumn('last_login_date');
            $table->dropColumn('mobile_no');
            $table->dropColumn('svc_no');
            $table->dropColumn('username');
            // $table->dropColumn('rank_id');
            // $table->dropColumn('regiment_id');
            // $table->dropColumn('location_id');
            $table->dropColumn('status');
        });
    }
};
