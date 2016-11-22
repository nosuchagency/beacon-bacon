<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PoiGetsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('pois', function ($table) {
		    $table->string('type');
		    $table->string('color');		    
		});
		
		Schema::table('locations', function ($table) {
		    $table->string('area', 1024);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('pois', function ($table) {
		    $table->dropColumn('type');
		    $table->dropColumn('color');		    
		});
		
		Schema::table('locations', function ($table) {
		    $table->dropColumn('area');
		});
    }
}
