<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatTravelPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('quota');
            $table->string('slug');
            $table->string('location');
            $table->longText('about');
            $table->boolean('lodging_house');
            $table->boolean('eat');
            $table->date('deperture_date');
            $table->string('duration');
            $table->string('type');
            $table->integer('price');
            $table->softDeletes();
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
        Schema::dropIfExists('travel_packages');
    }
}