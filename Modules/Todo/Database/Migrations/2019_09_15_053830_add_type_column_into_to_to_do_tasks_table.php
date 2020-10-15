<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeColumnIntoToToDoTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('to_do_tasks', function (Blueprint $table) {
            $table->integer('type')->default(1)->after('completed');
            $table->integer('priority_id')->nullable()->after('completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('to_do_tasks', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('priority_id');
        });
    }
}
