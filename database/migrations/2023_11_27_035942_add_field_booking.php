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
        Schema::table('bookings', function (Blueprint $table) {            
            $table->tinyInteger('refund_recieve')->default(0);
            $table->dateTime('refund_recieve_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {            
            $table->dropColumn('refund_recieve');
            $table->dropColumn('refund_recieve_time');            
        });
    }
};
