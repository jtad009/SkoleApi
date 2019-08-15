<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            // $table->increments('id');
            $table->uuid('id');
            $table->string('title');
            $table->integer('category_id');

            $table->text('article');
            $table->string('slug');
            $table->integer('view_count')->default(0);
            $table->integer('user_id');
           
            $table->string('cover_image');
            $table->string('comment_count')->default(0);
            $table->boolean('published')->default(false);
            $table->timestamps();
            $table->primary('id');
            // $table->foreign('user_id')->references('id')->on('users');//FK
            // $table->foreign('category_id')->references('id')->on('categories');//FK
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
