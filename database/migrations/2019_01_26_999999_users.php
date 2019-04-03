<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username')->nullable();
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');

            $table->date('bday');
            $table->string('mobilenumber');
            $table->string('email');

            $table->string('password')->nullable();

            $table->unsignedInteger('position_id');
            $table->foreign('position_id')->references('id')->on('position');            

            $table->string('remember_token')->nullable();

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
        Schema::dropIfExists('users');
    }
}
