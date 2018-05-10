<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToQuizzesQuestionsSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->integer('total_score')->default(0);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->integer('score')->default(0);
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->integer('total_score')->default(0);
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
    }
}
