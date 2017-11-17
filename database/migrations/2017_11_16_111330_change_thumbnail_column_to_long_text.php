<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeThumbnailColumnToLongText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        $sql = "ALTER TABLE `h_i_v_cares`
        CHANGE COLUMN `thumbnail` `thumbnail` LONGTEXT NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `title`;";

        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('h_i_v_cares', function(Blueprint $table){
            $table->text('thumbnail')->change();
        });
    }
}
