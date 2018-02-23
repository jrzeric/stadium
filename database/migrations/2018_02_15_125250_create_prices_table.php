<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event')->unsigned();
            $table->tinyInteger('section')->unsigned();
            $table->decimal('price', 7, 2);
            $table->foreign('event')->references('id')->on('events');
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
        Schema::dropIfExists('prices');
    }
}
