<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlaceExtended extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('places', function ($table) {
		    $table->string('address');
		    $table->string('zipcode');
		    $table->string('city');
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
		    $table->dropColumn('address');
		    $table->dropColumn('zipcode');
		    $table->dropColumn('city');
		});
    }
}