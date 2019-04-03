<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');

            $table->date('from');

            $table->time('time');

            $table->dateTime('appointment');

            $table->unsignedInteger('appointment_type');
            $table->foreign('appointment_type')->references('id')->on('appointment_type');

            $table->tinyInteger('is_approved')->default(0);
            $table->tinyInteger('is_done')->default(0);

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
        Schema::dropIfExists('appointments');
    }
}
