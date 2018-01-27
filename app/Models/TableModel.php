<?php


namespace App\Models;

use PDO;

class TableModel extends BaseModel
{
    public $limit = 100;

    public function tableContent($table, $sortBy, $sortType, $page)
    {
        $this->offset = ($page-1) * $this->limit;

        $result = $this->connection->query("SELECT * FROM $table ORDER BY $sortBy $sortType LIMIT $this->limit OFFSET $this->offset")
            ->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) < $this->limit){
           return [$result,true];
        }else{
            return [$result,false];
        }

    }
}