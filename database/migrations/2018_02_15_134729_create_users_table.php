<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
          $table->smallInteger('employee')->unsigned();
          $table->smallInteger('profile')->unsigned();
          $table->string('email')->unique();
          $table->string('password');
          $table->rememberToken();
          $table->char('status', 2)->default('UP');
          $table->timestamps();
          $table->primary('employee');
          $table->foreign('employee')->references('id')->on('employees');
          $table->foreign('profile')->references('id')->on('profiles');
          $table->engine = 'InnoDB';
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
