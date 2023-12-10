<?php

use Core\Lib\Route\Route;

return [
    'index' => Route::get('/', "AppController@index"),
    'test' => Route::get('/test', "AppController@test"),
    'api' => Route::get('/api', "AppController@api"),
];