<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FloorExtended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('floors', function ($table) {
		    $table->string('map_width_in_centimeters');
		    $table->string('map_height_in_centimeters');
		    $table->string('map_width_in_pixels');
		    $table->string('map_height_in_pixels');		    
		    $table->string('map_pixel_to_centimeter_ratio');
		    $table->string('map_walkable_color');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('floors', function ($table) {
		    $table->dropColumn('map_width_in_centimeters');
		    $table->dropColumn('map_height_in_centimeters');
		    $table->dropColumn('map_width_in_pixels');
		    $table->dropColumn('map_height_in_pixels');		    
		    $table->dropColumn('map_pixel_to_centimeter_ratio');
		    $table->dropColumn('map_walkable_color');		    
		});
    }
}
