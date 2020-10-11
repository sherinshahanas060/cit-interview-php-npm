<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('email');
            $table->integer('employee_id_number')->nullable();
            $table->date('join_date')->nullable();
            $table->integer('user_status')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('title')->nullable();
            $table->string('city')->nullable();
            $table->integer('speciality_id')->nullable();
            $table->string('work_place')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('department')->nullable();
            $table->string('profession')->nullable();
            $table->string('profile_image')->nullable();
            $table->integer('status')->default('1');
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
        Schema::dropIfExists('user_details');
    }
}
