<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableArticlesTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('article_id');
            $table->integer('tag_id');
            $table->primary('id');
            // $table->foreign('article_id')->references('id')->on('articles');//FK
            // $table->foreign('tag_id')->references('id')->on('tags');//FK
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
        Schema::drop('articles_tags');
    }
}
