<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCategoriesToPois extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {	    
		Schema::rename('categories', 'pois');
			    
		Schema::table('locations', function ($table) {
		    $table->renameColumn('category_id', 'poi_id');
		});
		
		Schema::table('menus', function ($table) {
		    $table->renameColumn('category_id', 'poi_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::rename('pois', 'categories');
			    
		Schema::table('locations', function ($table) {
		    $table->renameColumn('poi_id', 'category_id');
		});
		
		Schema::table('menus', function ($table) {
		    $table->renameColumn('poi_id', 'category_id');
		});
    }
}
