<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_card', function (Blueprint $table) {
            $table->bigInteger("id");
            $table->string("code");
            $table->foreignId("image_id")->nullable()->references("id")->on("images");
            $table->foreignId("created_by")->nullable()->references("id")->on("user");
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
        Schema::dropIfExists('student_card');
    }
}
