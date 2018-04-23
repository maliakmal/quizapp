<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('school')->unsigned()->nullable();
            $table->foreign('school')->references('id')->on('schools');
            $table->string('age', 20)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('grade', 100)->nullable();
            $table->string('type', 80)->nullable();

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
            //
        });
    }
}
