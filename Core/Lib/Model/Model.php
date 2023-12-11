<?php

namespace Core\Lib\Model;

use Core\App;

class Model
{

    protected static string $table = "";
    protected static ?string $alias = null;
    protected static string $pk = "id";
    protected static array $fields = [];

    public function __construct($data = [])
    {
        $this->{static::$pk} = $data[static::$pk];
        foreach (static::$fields as $field)
        {
            $this->{$field} = $data[$field] ?? null;
        }
    }

    public static function table() : string
    {
        return static::$table;
    }

    public static function alias() : string | null
    {
        return static::$alias;
    }

    public static function pk() : string
    {
        return static::$pk;
    }

    public static function fields() : array
    {
        return static::$fields;
    }

    public static function all() : array
    {
        $result = App::db()->all(static::$table);
        $rows = [];
        foreach ($result as $queryRow)
        {
            $rows[] = new static($queryRow);
        }
        return $rows;
    }

    public static function find(int | float | string $value, string $pk = null) : static | null
    {
        $pk = $pk ?? static::$pk;
        $result = App::db()->find(static::$table, $value, $pk);
        if (! $result)
        {
            return null;
        }
        return new static($result);
    }

}