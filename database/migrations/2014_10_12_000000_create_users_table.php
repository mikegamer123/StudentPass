<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname');
            $table->date('dateOfBirth');
            $table->string('index')->unique();
            $table->string('email')->unique();
            $table->string('emailToken')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('userType', ['User', 'Worker', 'Admin'])->default('User');
            $table->string('password');
            $table->boolean('isActive');
            $table->rememberToken();
            $table->timestamps();
        });

        //add key for authentication
        Schema::table('users', function ($table) {
            $table->string('api_token', 80)->after('password')
                ->unique()
                ->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
