<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassificationCountView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("CREATE VIEW assessment_classification_count_view AS SELECT a.id, COUNT(c.id) as classifications FROM assessments a
            LEFT JOIN assessment_classfications c ON a.id = c.assessment_id
            GROUP BY a.id;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("DROP VIEW assessment_classification_count_view");
    }
}
