<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Findables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('findables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_id');
            $table->string('name');
            $table->string('internal_name');
            $table->string('parameter_one_name');
            $table->string('parameter_two_name');
            $table->string('parameter_three_name');
            $table->string('parameter_four_name');
            $table->string('parameter_five_name');
            $table->integer('created_by');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('findables');
    }
}
