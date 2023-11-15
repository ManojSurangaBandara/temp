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
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
            $table->string('acc_no')->nullable();
            $table->decimal('paid_amount',10,2)->default(0.00);
            $table->integer('no_of_days')->default(0);
            $table->tinyInteger('sms_delivery_status')->default(0);//send->1, not-send->0
            $table->dateTime('sms_delivery_date_time')->nullable();
            $table->tinyInteger('cancel_sms_delivery_status')->default(0);
            $table->dateTime('cancel_msg_date_time')->nullable();
            $table->string('confirm_msg_contain')->nullable();
            $table->string('cancel_msg_contain')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {            
            $table->dropColumn('bank_id');
            $table->dropColumn('acc_no');
            $table->dropColumn('paid_amount');
            $table->dropColumn('no_of_days');
            $table->dropColumn('sms_delivery_status');
            $table->dropColumn('sms_delivery_date_time');
            $table->dropColumn('cancel_sms_delivery_status');
            $table->dropColumn('cancel_msg_date_time');
            $table->dropColumn('confirm_msg_contain');
            $table->dropColumn('cancel_msg_contain');
        });
    }
};
