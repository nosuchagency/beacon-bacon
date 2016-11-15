<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlacesJustCantStop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('places', function ($table) {
			$table->boolean('beacon_positioning_enabled');
			$table->boolean('beacon_proximity_enabled');
			$table->integer('order');			
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
		    $table->dropColumn('beacon_positioning_enabled');
		    $table->dropColumn('beacon_proximity_enabled');
		    $table->dropColumn('order');
		});
    }
}
