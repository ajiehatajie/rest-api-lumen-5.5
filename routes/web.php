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

$router->group(['prefix' => 'api/'], function ($router) {

    $router->get('/key', function() {
        $key= \Auth::user()->id;
        return $key;
    });
    $router->get('/user/{id}', ['uses'=>'UsersController@get_user','middleware'=>'auth']);

    $router->post('/login', 'LoginController@index');
    $router->get('/users','UsersController@index');
    $router->post('/users',['uses'=>'UsersController@create']);

    $router->get('/ektp','KtpController@index');
    $router->get('/ektp/created','KtpController@KtpCreated');
    $router->post('/ektp',['uses'=>'KtpController@create','middleware'=>'auth']);
    $router->get('/ektp/{kecamatan}/{date}',['uses'=>'KtpController@show']);
    $router->post('/ektp/{date}/update',['uses'=>'KtpController@update','middleware'=>'auth']);
    
    $router->post('/ektp/{id}/delete',['uses'=>'KtpController@destroy','middleware'=>'auth']);

    $router->get('/kecamatan','KecamatanController@index');
    $router->get('/kecamatan/{id}/ktp','KecamatanController@ktp');

    $router->post('/kecamatan',['uses'=>'KecamatanController@create','middleware'=>'auth']);
    $router->get('/kecamatan/{id}','KecamatanController@show');
    $router->post('/kecamatan/{id}/delete',['uses'=>'KecamatanController@destroy','middleware'=>'auth']);

});

$router->get('/', function () use ($router) {
    $record = app()->geoip->getLocation();

    return $record['ip'];
    //return $router->app->version();
});
