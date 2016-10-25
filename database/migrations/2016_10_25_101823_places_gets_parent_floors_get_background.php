<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlacesGetsParentFloorsGetBackground extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('places', function ($table) {
		    $table->integer('place_id');
		});
		
		Schema::table('floors', function ($table) {
		    $table->string('map_background_color');
		});		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('places', function ($table) {
		    $table->dropColumn('place_id');
		});

		Schema::table('floors', function ($table) {
		    $table->dropColumn('map_background_color');
		});
    }
}