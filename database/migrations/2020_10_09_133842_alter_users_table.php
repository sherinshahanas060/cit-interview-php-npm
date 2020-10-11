<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('is_user')->default(0)->after('email');
            $table->integer('status')->default(1)->after('password');
            $table->string('password')->nullable()->change();
            $table->integer('is_delegate')->default(0)->after('password');
            $table->integer('is_employee')->default(0)->after('password');
            $table->integer('user_status')->default(1)->after('email');
            $table->integer('email_validated')->default(0)->after('email');
            $table->integer('mobile_validated')->default(0)->after('email');
            $table->integer('user_score')->default(5)->after('email');
            $table->string('verification_code')->nullable()->after('email_validated');
            $table->string('subscription')->default(0)->after('verification_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_user');
            $table->dropColumn('status');
            $table->dropColumn('is_delegate');
            $table->dropColumn('is_employee');
            $table->dropColumn('user_status');
            $table->dropColumn('email_validated');
            $table->dropColumn('mobile_validated');
            $table->dropColumn('user_score');
            $table->dropColumn('verification_code');
            $table->dropColumn('subscription');
        });
    }
}
