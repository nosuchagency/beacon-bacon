<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdentifiersPlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->renameColumn('identifier', 'identifier1');
            $table->string('identifier5')->after('identifier');
            $table->string('identifier4')->after('identifier');
            $table->string('identifier3')->after('identifier');
            $table->string('identifier2')->after('identifier');
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
            $table->renameColumn('identifier1', 'identifier');
            $table->dropColumn('identifier2');
            $table->dropColumn('identifier3');
            $table->dropColumn('identifier4');
            $table->dropColumn('identifier5');
        });
    }
}
