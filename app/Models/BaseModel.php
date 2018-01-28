<?php


namespace App\Models;
use PDO;
class BaseModel
{
    protected $connection;

    public function __construct($container)
    {
        $this->connection = $container->get('mysql');
    }

    public function table($table)
    {
        return $this->connection->table($table);
    }

    public function query($query)
    {
        return $this->connection->query($query);
    }
}