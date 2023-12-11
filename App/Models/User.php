<?php

namespace App\Models;

use Core\Lib\Model\Model;

class User extends Model
{
    protected static string $table = "users";
    protected static ?string $alias = "u";
    protected static string $pk = "id";
    protected static array $fields = [
        "first_name",
        "last_name",
        "email",
        "password",
    ];

    protected int $id;
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected string $password;
}