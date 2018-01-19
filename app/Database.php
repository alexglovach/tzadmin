<?php

namespace App;
use PDO;

class Database
{
    public $dbc;

    public function connect()
    {
//        $this->connection = new PDO($config["driver"].':host='.$config["host"].';dbname='.$config["database"],
//            $config["username"],
//            $config["password"]);

        $dbc = new PDO('mysql:host=localhost;dbname=test_vk_parser',
            'root',
            'root');
        return $dbc;
    }
    public function table($table)
    {
        return $this->dbc->table($table);
    }
    public function query($query)
    {
        return $this->dbc->query($query)->fetchAll(PDO::FETCH_COLUMN);
    }

}