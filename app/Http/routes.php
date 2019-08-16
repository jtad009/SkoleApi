<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});
$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers', 'middleware' => 'auth'], function () use ($app) {
    $app->post('articles/edit/{id}', 'ArticlesController@edit');
    $app->delete('articles/delete/{id}', 'ArticlesController@delete');
    $app->post('articles/add', 'ArticlesController@add');
    $app->get('users/view/{id}', 'UsersController@view');
    $app->get('users/all', 'UsersController@index');
    $app->get('users/view/{id}/articles', 'UsersController@viewWithArticles');

    $app->post('comments/add', 'CommentsController@add');
    $app->delete('comments/delete/{id}', 'CommentsController@delete');

    $app->post('categories/add', 'CategoriesController@add');
    $app->post('categories/edit/{id}', 'CategoriesController@edit');
    $app->get('categories/view/{id}', 'CategoriesController@view');
    $app->get('categories/all', 'CategoriesController@index');

    $app->post('tags/add', 'TagsController@add');
    $app->post('tags/edit/{id}', 'TagsController@edit');
    $app->get('tags/view/{id}', 'TagsController@view');
    $app->get('tags/all', 'TagsController@index');
});

$app->group(['prefix' => 'api/v1', 'namespace' => 'App\Http\Controllers'], function ($app) {
    //Article Routes
    $app->get('articles/view/{id}', 'ArticlesController@view');
    $app->get('articles/all', 'ArticlesController@index');
    
    //Users route
    $app->post('users/add', 'UsersController@add');
});
