<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('team_id');
            $table->string('name');
            $table->integer('created_by');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->string('name');
            $table->string('internal_name');
            $table->string('icon');
            $table->integer('created_by');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('place_id');
            $table->string('name');
            $table->integer('order')->default(0);
            $table->string('image');
            $table->integer('created_by');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('place_id');
            $table->integer('map_id');
            $table->integer('category_id');
            $table->string('name');
            $table->integer('posX');
            $table->integer('posY');
            $table->integer('created_by');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('beacons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->integer('place_id');
            $table->integer('map_id');
            $table->string('name');
            $table->text('description');
            $table->string('posX');
            $table->string('posY');
            $table->integer('created_by');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('places');
        Schema::drop('categories');
        Schema::drop('maps');
        Schema::drop('locations');
        Schema::drop('beacons');
    }
}
