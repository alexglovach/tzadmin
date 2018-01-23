<?php


namespace App\Models;


class TablesListModel extends BaseModel
{
    public function getList() {
        return $this->connect()->query("show tables")->fetchAll(\PDO::FETCH_COLUMN);
    }
}