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
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('mobile')->unique();
            $table->string('image');
            $table->string('role');
            $table->string('device_token')->nullable();
            $table->string('device_type')->nullable();
            $table->boolean('notification')->default(1);
            $table->string('salon_type');
            $table->string('address');
            $table->integer('salon_id');
            $table->string('status');
            $table->string('service');
            $table->string('lat_long');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
