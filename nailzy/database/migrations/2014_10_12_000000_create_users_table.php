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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->bigInteger('mobile')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('role')->nullable();
            $table->string('device_token')->nullable();
            $table->string('device_type')->nullable();
            $table->boolean('notification')->default(1);
            $table->string('salon_type')->nullable();
            $table->string('address')->nullable();
            $table->integer('salon_id')->nullable();
            $table->string('status')->default('active');
            $table->string('service')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
};
