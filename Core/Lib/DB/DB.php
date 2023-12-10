<?php

namespace Core\Lib\DB;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\DriverManager;

class DB
{

    private Connection $conn;

    public function connect()
    {
        $this->conn = DriverManager::getConnection([
            'dbname' => env('MARIADB_DATABASE'),
            'user' => env('MARIADB_USER'),
            'password' => env('MARIADB_PASSWORD'),
            'host' => env('MARIADB_HOST'),
            'port' => env('MARIADB_PORT'),
            'driver' => 'pdo_mysql',
            'charset' => env('MARIADB_CHARSET'),
        ]);
    }

    public function conn() : Connection
    {
        return $this->conn;
    }

    public function prepare(string $sql)
    {
        return $this->conn->prepare($sql);
    }

    public function builder() : QueryBuilder
    {
        return $this->conn->createQueryBuilder();
    }

    public function all(string $table) : array
    {
        return $this->builder()->select('*')->from($table)->fetchAllAssociative();
    }

    public function find(string $table, int | float | string $value, string $field = "id") : null | array
    {
        return $this->builder()->select('*')->from($table)->where("$field = :value")->setParameter("value", $value)->fetchAssociative();
    }

    public function findAll(string $table, int | float | string $value, string $field = "id") : null | array
    {
        return $this->builder()->select('*')->from($table)->where("$field = :value")->setParameter("value", $value)->fetchAllAssociative();
    }

    public function findLike(string $table, int | float | string $value, string $field = "id") : null | array
    {
        return $this->builder()->select('*')->from($table)->where("$field like :value")->setParameter("value", "%$value%")->fetchAssociative();
    }

    public function findAllLike(string $table, int | float | string $value, string $field = "id") : null | array
    {
        return $this->builder()->select('*')->from($table)->where("$field like :value")->setParameter("value", "%$value%")->fetchAllAssociative();
    }

    public function insert(string $table, array $data)
    {
        $values = [];
        foreach ($data as $k => $v)
        {
            $values[$k] = ":$k";
        }
        $qb = $this->builder()->insert($table)->values($values);
        foreach ($data as $k => $v)
        {
            $qb->setParameter($k, $v);
        }
        return $qb->executeQuery();
    }

    public function update(string $table, array $data, int | float | string $value, string $field = "id")
    {
        $qb = $this->builder()->update($table);
        foreach ($data as $k => $v)
        {
            $qb->set($k, ":$k");
            $qb->setParameter($k, $v);
        }
        $qb->where("$field = :pk_$field");
        $qb->setParameter(":pk_$field", $value);
        return $qb->executeQuery();
    }

    public function delete(string $table, int | float | string $value, string $field = 'id')
    {
        return $this->builder()->delete($table)->where("$field = :$field")->setParameter($field, $value)->executeQuery();
    }
}