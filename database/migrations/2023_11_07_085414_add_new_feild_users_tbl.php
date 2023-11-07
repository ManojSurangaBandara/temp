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
            $table->string('mobile_no')->unique();
            $table->string('svc_no')->unique();
            $table->string('username')->unique();
            $table->unsignedBigInteger('rank_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_login_ip');
            $table->dropColumn('suspend');
            $table->dropColumn('status');
            $table->dropColumn('phone');
            $table->dropColumn('attempts');
            $table->dropColumn('backlist');
        });
    }
};
