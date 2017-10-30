<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangedContentCanBeNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('treat_ailments', function(Blueprint $table){
            $table->text('content')->nullable()->change();
        });

        Schema::table('treat_titles', function(Blueprint $table){
            $table->text('guide')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
         Schema::table('treat_ailments', function(Blueprint $table){
            $table->text('content')->change();
        });

        Schema::table('treat_titles', function(Blueprint $table){
            $table->text('guide')->change();
        });
    }
}
