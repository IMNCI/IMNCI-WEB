<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentsColumnToHivCare extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_i_v_cares', function (Blueprint $table) {
            $table->integer('parent_id')->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_i_v_cares', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}
