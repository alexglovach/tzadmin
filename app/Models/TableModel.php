<?php


namespace App\Models;

use PDO;

class TableModel extends BaseModel
{
    private $limit = 1000;

    public function tableContent($table, $sortBy, $sortType)
    {
        return $this->connection->query("SELECT * FROM $table ORDER BY $sortBy $sortType LIMIT $this->limit")
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}