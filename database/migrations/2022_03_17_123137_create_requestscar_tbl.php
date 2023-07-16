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
        Schema::create('requests_cars', function (Blueprint $table) {
            $table->id();
            $table->string('requestNo');
            $table->integer('user_id');
            $table->integer('type_id');
            $table->integer('car_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('status_set_id')->nullable();
            $table->integer('department_car');
            $table->integer('passenger');
            $table->integer('want_driver');
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->string('location');
            $table->string('detail')->nullable();
            $table->string('status_id');
            $table->integer('first_mileage')->nullable();
            $table->integer('current_mileage')->nullable();
            $table->integer('run_mileage')->nullable();
            $table->double('price_oil')->nullable();
            $table->string('slip_oil')->nullable();
            $table->string('returndetail')->nullable();
            $table->dateTime('returnTime')->nullable();
            $table->integer('status_return')->nullable();
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests_cars');
    }
};
