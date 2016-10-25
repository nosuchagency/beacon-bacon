<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FindablesChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('findables', function ($table) {
		    $table->renameColumn('internal_name', 'identifier');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('findables', function ($table) {
		    $table->renameColumn('identifier', 'internal_name');
		});
    }
}
