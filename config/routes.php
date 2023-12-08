<?php

use Core\Lib\Route;

return [
    'index' => Route::get('/', "AppController@index"),
    'test' => Route::get('/test', "AppController@test")
];