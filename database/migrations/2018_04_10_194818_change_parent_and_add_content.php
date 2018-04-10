<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeParentAndAddContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('h_i_v_cares', function (Blueprint $table) {
            $table->text('content')->after('title');
            $table->string('parent')->after('content');
            $table->integer('parent_id')->nullable()->change();
            $table->text('thumbnail')->nullable()->change();
            $table->text('image_path')->nullable()->change();
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
            $table->dropColumn(['content', 'parent']);
            $table->text('image_path')->change();
            $table->integer('parent_id')->change();

            $sql = "ALTER TABLE `h_i_v_cares`
            CHANGE COLUMN `thumbnail` `thumbnail` LONGTEXT NOT NULL COLLATE 'utf8mb4_unicode_ci' AFTER `title`;";

            DB::connection()->getPdo()->exec($sql);
        });
    }
}
