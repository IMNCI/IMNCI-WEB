<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DroppedSignAndTreatmentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::drop('assessment_classification_signs');
        Schema::drop('assessment_classification_treatments');

        Schema::table('assessment_classfications', function (Blueprint $table) {
            $table->text('signs');
            $table->text('treatments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('assessment_classification_signs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('classification_id');
            $table->string('sign');
            $table->timestamps();
        });

        Schema::create('assessment_classification_treatments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('classification_id');
            $table->string('treatment');
            $table->timestamps();
        });

        Schema::table('assessment_classfications', function (Blueprint $table) {
            $table->dropColumn(['signs', 'treatments']);
        });
    }
}
