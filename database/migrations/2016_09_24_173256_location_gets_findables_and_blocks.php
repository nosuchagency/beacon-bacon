<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocationGetsFindablesAndBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('locations', function ($table) {
		    $table->integer('block_id');
		    $table->integer('findable_id');
		    $table->integer('rotation');		    		    			
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
		    $table->dropColumn('block_id');
		    $table->dropColumn('findable_id');
		    $table->dropColumn('rotation');
		});
    }
}