<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BlocksGetSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('blocks', function ($table) {
		    $table->integer('height');
		    $table->integer('width');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('blocks', function ($table) {
		    $table->dropColumn('height');
		    $table->dropColumn('width');
		});
    }
}
