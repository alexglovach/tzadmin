<?php


namespace App\Models;


class TablesListModel extends BaseModel
{
    public function getList() {
        return $this->connection->query("show tables")->fetchAll(\PDO::FETCH_COLUMN);
    }
}