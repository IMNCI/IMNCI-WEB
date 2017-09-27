<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgeGroupAilmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ailments', function (Blueprint $table) {
            $table->integer('age_group_id')->unsigned();
            $table->foreign('age_group_id')->references('id')->on('age_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ailments', function (Blueprint $table) {
            //
        });
    }
}
