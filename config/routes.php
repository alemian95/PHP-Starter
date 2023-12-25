<?php

use Core\Lib\Route\Route;

return [
    'index' => Route::get('/', "AppController@index"),
    'test' => Route::get('/test', "AppController@test"),
    'login' => Route::get('/login', "AppController@login"),
    'jwt' => Route::get('/jwt', "AppController@jwt"),
    'api' => Route::get('/api', "AppController@api")->middlewares([ 'JwtApiAuthorization' ]),
];