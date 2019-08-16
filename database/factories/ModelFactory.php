<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    static $password  ;
    return [
        'first_name' => $faker->name,
        'last_name'=>$faker->name,
        'email' => $faker->email,
        'password' => $password ?: $password=app('hash')->make('secret'),
        'remember_token' => str_random(60),
        'api_token' => uniqid(str_random(60)),
        'bio'=>str_random(60),
        'image'=>str_random(10).'.png',
        'canWrite'=>0,
        'article_count'=>1
    ];
});
$factory->define(App\Model\Tag::class, function ($faker) {
    return [
        'tag' => $faker->name,
        'id'=>1
    ];
});
$factory->define(App\Model\ArticlesTags::class, function ($faker) {
    static $password;
    return [
        'tag_id' => 1,
        'article_id' => '290fc048-bf15-11e9-bb04-f0761cc3045a'
    ];
});
$factory->define(App\Model\Category::class, function ($faker) {
    
    return [
        'category' => $faker->name,
        'article_count'=>1,
        'id'=>1
    ];
});
$factory->define(App\Model\Comment::class, function ($faker) {
    
    return [
        'comment' => $faker->name,
        'article_id'=>'290fc048-bf15-11e9-bb04-f0761cc3045a',
        'published'=>0,
        'name'=>$faker->name,
        'website'=>'skole.com.ng',
        'email'=>$faker->email,
        
    ];
});
$factory->define(App\Model\Article::class, function ($faker) {
    
    return [
        'category_id' => 1,
        'article' => str_random(200),
        'title' => $faker->name,
        'slug' => $faker->name,
        'comment_count' => 1,
        'view_count' => 1,
        'user_id'=>1,
        'cover_image'=>str_random(10).'.png',
        'published'=>0,
        'id'=>'290fc048-bf15-11e9-bb04-f0761cc3045a'
        
    ];
});


