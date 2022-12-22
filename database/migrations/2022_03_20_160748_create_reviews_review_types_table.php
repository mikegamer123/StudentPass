<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsReviewTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews_review_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reviewType_id');
            $table->unsignedBigInteger('review_id');

            //foreign key constraints
            $table->foreign('reviewType_id')->references('id')->on('review_type');
            $table->foreign('review_id')->references('id')->on('reviews');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews_review_types');
    }
}
