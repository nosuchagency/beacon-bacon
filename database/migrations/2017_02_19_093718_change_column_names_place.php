<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNamesPlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->renameColumn('identifier1', 'identifier_one');
            $table->renameColumn('identifier2', 'identifier_two');
            $table->renameColumn('identifier3', 'identifier_three');
            $table->renameColumn('identifier4', 'identifier_four');
            $table->renameColumn('identifier5', 'identifier_five');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->renameColumn('identifier_one', 'identifier1');
            $table->renameColumn('identifier_two', 'identifier2');
            $table->renameColumn('identifier_three', 'identifier3');
            $table->renameColumn('identifier_four', 'identifier4');
            $table->renameColumn('identifier_five', 'identifier5');
        });
    }
}
