<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('article_count');
            $table->text('bio');
            $table->string('password');
            $table->string('api_token')->unique();
            $table->rememberToken();
            $table->boolean('canWrite')->default(false);;
            $table->string('image');
            $table->string('email')->unique();
            $table->timestamps();
            $table->primary('id');
            s
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
