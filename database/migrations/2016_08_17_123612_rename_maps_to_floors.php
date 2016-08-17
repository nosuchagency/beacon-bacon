<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameMapsToFloors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::rename('maps', 'floors');
			    
		Schema::table('beacons', function ($table) {
		    $table->renameColumn('map_id', 'floor_id');
		});
		
		Schema::table('locations', function ($table) {
		    $table->renameColumn('map_id', 'floor_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::rename('floors', 'maps');
			    
		Schema::table('beacons', function ($table) {
		    $table->renameColumn('floor_id', 'map_id');
		});
		
		Schema::table('locations', function ($table) {
		    $table->renameColumn('floor_id', 'map_id');
		});
    }
}
