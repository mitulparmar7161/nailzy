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
        Schema::create('employee_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            // $table->foreign('customer_id')->references('id')->on('users'); 
            $table->bigInteger('employee_id');
            // $table->foreign('employee_id')->references('id')->on('users');
            $table->text('employee_comment');
            $table->integer('employee_rating');
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
        Schema::dropIfExists('employee_reviews');
    }
};
