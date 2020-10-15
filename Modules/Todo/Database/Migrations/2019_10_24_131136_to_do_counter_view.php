<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ToDoCounterView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("
        CREATE OR REPLACE VIEW to_do_counter AS
SELECT
  b.`assigned_to` AS user_id  ,COUNT(a.`id`) as count
FROM
  `to_do_tasks` AS a
   LEFT JOIN`to_do_task_assigns` AS b ON
  a.`id`=b.`to_do_task_id`
WHERE a.`status` = 1 AND a.`completed`=0
GROUP BY b.`assigned_to`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("DROP VIEW to_do_counter");
    }
}
