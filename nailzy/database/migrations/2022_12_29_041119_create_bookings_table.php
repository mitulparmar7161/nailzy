<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salon_id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->date('booking_date');
            $table->time('timeslot_start');
            $table->time('timeslot_end');
            $table->double('billing_cost');
            $table->text('booking_remark');
            $table->string('booking_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
