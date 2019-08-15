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

$app->group(['prefix'=>'api/v1','namespace'=>'App\Http\Controllers'], function($app){
    //Article Routes
   // $app->group(['prefix'=>''], function($app){
        $app->post('add', 'ArticlesController@add');
        $app->get('articles/view/{id}', 'ArticlesController@view');
        $app->put('update/{id}', 'ArticlesController@edit');
        $app->delete('delete/{id}', 'ArticlesController@delete');
        $app->get('articles/all', 'ArticlesController@index');
    //});
    

    //Users route
    // $app->group(['prefix'=>'users'], function($app){
        $app->post('add', 'UsersController@add');
        $app->get('all', 'UsersController@all');
        $app->get('view', 'UsersController@view');
    // });
});
