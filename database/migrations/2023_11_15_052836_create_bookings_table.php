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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('regiment');
            $table->string('unit');
            $table->string('svc_no');
            $table->string('name');
            $table->string('nic');
            $table->string('contact_no')->nullable();
            $table->string('army_id')->nullable();
            $table->unsignedBigInteger('bungalow_id');
            $table->foreign('bungalow_id')->references('id')->on('bungalows')->onDelete('cascade');
            $table->unsignedBigInteger('cancelremark_id')->nullable();
            $table->foreign('cancelremark_id')->references('id')->on('cancel_remarks')->onDelete('cascade');
            $table->tinyInteger('type');//serving->0, retired->1, official->2
            $table->tinyInteger('save')->default(0);//save->1, not-save->0
            $table->tinyInteger('level')->default(0);
            $table->date('check_in');
            $table->date('check_out');
            $table->string('eno')->nullable();
            $table->string('filpath')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
