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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('regisNumber');
            $table->integer('type_id');
            $table->integer('brand_id');
            $table->integer('model_id');
            $table->integer('color_id');
            $table->integer('province_id');
            $table->integer('department_id');
            $table->integer('capacity');
            $table->integer('mileage');
            $table->integer('status_id');
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('cars');
    }
};
