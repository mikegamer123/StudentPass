<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //added images table
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string("path");
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table)
        {
            //foreign keys
            $table->foreignId('image_id')->nullable()->references('id')->on('images');
        });
        Schema::table('posts', function (Blueprint $table)
        {
            $table->foreignId('image_id')->nullable()->references('id')->on('images');
        });
        Schema::table('news', function (Blueprint $table)
        {
            //foreign keys
            $table->foreignId('image_id')->nullable()->references('id')->on('images');
        });
        Schema::table('companies', function (Blueprint $table)
        {
            //foreign keys
            $table->foreignId('image_id')->nullable()->references('id')->on('images');
        });
        Schema::table('college', function (Blueprint $table)
        {
            //foreign keys
            $table->foreignId('image_id')->nullable()->references('id')->on('images');
        });
        Schema::table('images', function (Blueprint $table)
        {
            //foreign keys
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('users', function (Blueprint $table)
        {
            //foreign keys
            $table->dropColumn('image_id');
        });
        Schema::table('posts', function (Blueprint $table)
        {
            $table->dropColumn('image_id');
        });
        Schema::table('news', function (Blueprint $table)
        {
            //foreign keys
            $table->dropColumn('image_id');
        });
        Schema::table('companies', function (Blueprint $table)
        {
            //foreign keys
            $table->dropColumn('image_id');
        });
        Schema::table('college', function (Blueprint $table)
        {
            //foreign keys
            $table->dropColumn('image_id');
        });
        Schema::table('images', function (Blueprint $table)
        {
            //foreign keys
            $table->dropColumn('user_id');
        });
        Schema::dropIfExists('images');
    }
}
