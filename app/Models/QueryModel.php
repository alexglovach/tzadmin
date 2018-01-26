<?php


namespace App\Models;


class QueryModel extends BaseModel
{
    public function query($sql)
    {
        return $this->connection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

}