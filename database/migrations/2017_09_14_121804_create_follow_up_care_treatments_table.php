<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowUpCareTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_up_care_treatments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ailment_id')->unsigned();
            $table->text('treatment')->nullable();
            $table->foreign('ailment_id')->references('id')->on('ailments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_up_care_treatments');
    }
}
