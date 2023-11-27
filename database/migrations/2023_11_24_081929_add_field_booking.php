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
            $table->dateTime('cancel_time')->nullable();
            $table->tinyInteger('cancel')->default(0);
            $table->unsignedBigInteger('cancel_user_id')->nullable();
            $table->foreign('cancel_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('refund')->default(0);
            $table->dateTime('refund_time')->nullable();
            $table->unsignedBigInteger('refund_user_id')->nullable();
            $table->foreign('refund_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {            
            $table->dropColumn('cancel_time');
            $table->dropColumn('cancel');
            $table->dropColumn('cancel_user_id');
            $table->dropColumn('refund');
            $table->dropColumn('refund_time');
            $table->dropColumn('refund_user_id');
        });
    }
};
