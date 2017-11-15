<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('county');
        });

        Schema::table('users', function(Blueprint $table){
            // $sql = 'ALTER TABLE `users` MODIFY `age` DATETIME';
            if (!Storage::disk('local')->exists('counties.sql')) {
                throw new Exception('Counties SQL statement not found');
            }

            $sql = Storage::disk('local')->get('counties.sql');
            DB::connection()->getPdo()->exec($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counties');
    }
}
