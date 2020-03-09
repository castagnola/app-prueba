<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('starting_city_id')->unsigned();
            $table->foreign('starting_city_id')->references('id')->on('cities');
            $table->integer('destination_city_id')->unsigned();
            $table->foreign('destination_city_id')->references('id')->on('cities');
            $table->tinyInteger('tipe_route');
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
        Schema::dropIfExists('routes');
    }
}
