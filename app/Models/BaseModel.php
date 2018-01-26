<?php


namespace App\Models;

use PDO;

/**
 * @property \App\Database connection
 */
class BaseModel
{
    protected $connection;

    public function __construct($config)
    {
        $this->connection = new PDO($config["driver"].':host='.$config["host"].';dbname='.$config["database"],
            $config["username"],
            $config["password"]);

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