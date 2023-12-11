<?php

require_once __DIR__ . "/vendor/autoload.php";

use Doctrine\DBAL\DriverManager;

return DriverManager::getConnection([
    'dbname' => env('MARIADB_DATABASE'),
    'user' => 'root',
    'password' => env('MARIADB_ROOT_PASSWORD'),
    'host' => env('MARIADB_HOST'),
    'port' => env('MARIADB_PORT'),
    'driver' => 'pdo_mysql',
    'charset' => env('MARIADB_CHARSET'),
]);