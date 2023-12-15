<?php

namespace App\Models;

use Core\Lib\Model\Model;

class User extends Model
{
    protected static string $table = "users";
    protected static ?string $alias = "u";
    protected static array $fields = [
        "first_name",
        "last_name",
        "email",
        "password",
    ];

    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
}