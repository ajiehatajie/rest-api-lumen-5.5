<?php

$router->group(['prefix' => 'api/'], function ($router) {

    #user
    $router->get('/user/{id}', ['uses'=>'UsersController@get_user','middleware'=>'auth']);
    $router->post('/login', 'LoginController@index');
    $router->get('/users',['uses'=>'UsersController@index','middleware'=>'auth']);
    $router->post('/users',['uses'=>'UsersController@create','middleware'=>'auth']);
    #end user

    #ektp
    $router->get('/ads',['uses'=>'AdsController@index','middleware'=>'auth']);
    $router->get('/ektp',['uses'=>'KtpController@index','middleware'=>'auth']);
    $router->get('/ektp/created',['uses'=>'KtpController@KtpCreated','middleware'=>'auth']);
    $router->post('/ektp',['uses'=>'KtpController@create','middleware'=>'auth']);
    $router->get('/ektp/{kecamatan}/{date}',['uses'=>'KtpController@show']);
    $router->post('/ektp/{date}/update',['uses'=>'KtpController@update','middleware'=>'auth']);
    $router->post('/ektp/{id}/delete',['uses'=>'KtpController@destroy','middleware'=>'auth']);
    #end EKTP

    #kecamatan 
    $router->get('/kecamatan',['uses'=>'KecamatanController@index','middleware'=>'auth']);
    $router->get('/kecamatan/{id}/ktp',['uses'=>'KecamatanController@ktp','middleware'=>'auth']);
    $router->post('/kecamatan',['uses'=>'KecamatanController@create','middleware'=>'auth']);
    $router->get('/kecamatan/{id}',['uses'=>'KecamatanController@show','middleware'=>'auth']);
    $router->post('/kecamatan/{id}/delete',['uses'=>'KecamatanController@destroy','middleware'=>'auth']);
    #end kecamatan

    //check version
    $router->get('/versions/apps',['uses'=>'VersionController@index','middleware'=>'auth']);
    
    $router->get('/versions',function(){
        $data =['version'=>'V1','author'=>'Ajie Hatajie',
        'email'=>'me@hatajie.com','twitter'=>'@ajiehatajie'];
        
        $response = [
            'code' => 200,
            'status' => 'succcess',
            'data' => $data
            ];
        
        return response()->json($response, $response['code']);
    });

});

$router->get('/', function () use ($router) {

    return $router->app->version();
});
