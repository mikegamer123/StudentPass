<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCollegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_college', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('college_id');
            $table->date('educationStartYear');
            $table->unsignedBigInteger('studyProgramId');
            $table->timestamps();

            //foreign constraints
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('college_id')->references('id')->on('college');
            $table->foreign('studyProgramId')->references('id')->on('study_programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_college');
    }
}
