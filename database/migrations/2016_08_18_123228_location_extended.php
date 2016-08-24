<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocationExtended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('locations', function ($table) {
		    $table->integer('beacon_id');
		    $table->string('type');
		    $table->string('parameter_one');
		    $table->string('parameter_two');
		    $table->string('parameter_three');
		    $table->string('parameter_four');
		    $table->string('parameter_five');
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
		    $table->dropColumn('beacon_id');
		    $table->dropColumn('type');
		    $table->dropColumn('parameter_one');
		    $table->dropColumn('parameter_two');
		    $table->dropColumn('parameter_three');
		    $table->dropColumn('parameter_four');
		    $table->dropColumn('parameter_five');		    
		});
    }
}