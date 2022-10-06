<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories
     *
     * For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
     * To not introduce additional complexity, please consider only one cinema.
     *
     * Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.
     *
     * ## User Stories
     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out
     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms
     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat
     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('movies', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('booked_out')->default(false);
            $table->timestamps();
        });

        Schema::create('times', function ($table) {
            $table->increments('id');
            $table->dateTime('time');
            $table->timestamps();
        });

        Schema::create('movies_times', function ($table) {
            $table->increments('id');
            $table->integer('time_id')->unsigned()->nullable();
            $table->foreign('time_id')->references('id')->on('times');
            $table->integer('movie_id')->unsigned()->nullable();
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->timestamps();
        });

        Schema::create('seats', function ($table) {
            $table->increments('id');
            $table->string('seat_name');
            $table->string('seat_type');
            $table->string('seat_percentage');
            $table->boolen('seat_available');
            $table->timestamps();
        });

        Schema::create('pricing', function ($table) {
            $table->increments('id');
            $table->float('price');
            $table->integer('seat_id')->unsigned()->nullable();
            $table->foreign('seat_id')->references('id')->on('seats');
            $table->integer('movie_id')->unsigned()->nullable();
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->timestamps();
        });

        Schema::create('tickets', function ($table) {
            $table->increments('id');
            $table->string('ticket_number');
            $table->integer('pricing_id')->unsigned()->nullable();
            $table->foreign('pricing_id')->references('id')->on('pricing');
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
    }
}
