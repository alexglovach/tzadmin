<?php


namespace App\Models;


class QueryModel extends BaseModel
{
    public function query($sql)
    {
        return $this->connect()->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

}