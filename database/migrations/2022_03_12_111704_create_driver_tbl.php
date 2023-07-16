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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->integer('prefix_id');
            $table->string('drivernumber');
            $table->string('drivernumber_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->dateTime('birthday');
            $table->string('tel');
            $table->integer('status_id');
            $table->integer('active')->default(1);
            $table->dateTime('starttime')->nullable();
            $table->dateTime('endtime')->nullable();
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
        Schema::dropIfExists('drivers');
    }
};
