<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->char('row', 1);
            $table->string('column', 3);
            $table->tinyInteger('section')->unsigned();
            $table->char('status', 2);
            $table->primary('id');
            $table->foreign('section')->references('id')->on('sections');
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
        Schema::dropIfExists('seats');
    }
}
