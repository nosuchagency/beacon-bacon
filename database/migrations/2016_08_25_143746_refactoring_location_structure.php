<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactoringLocationStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('locations', function ($table) {
		    $table->dropColumn('beacon_id');
		});
	    
		Schema::table('beacons', function ($table) {
		    $table->integer('location_id');
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('locations', function ($table) {
		    $table->integer('beacon_id');
		});

		Schema::table('beacons', function ($table) {
		    $table->dropColumn('location_id');
		});
    }
}
