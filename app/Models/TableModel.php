<?php


namespace App\Models;

use PDO;

class TableModel extends BaseModel
{   private $limit = 1000;
    public function listColoumNames($table)
    {
        return $this->connect()->query("SHOW COLUMNS FROM $table")->fetchAll(PDO::FETCH_COLUMN);
    }

    public function tableContent($table)
    {
        return $this->connect()->query("SELECT * FROM $table LIMIT $this->limit")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tableSortBy($table, $sortBy, $sortType = 'DESC')
    {
        return $this->connect()->query("SELECT * FROM $table ORDER BY $sortBy $sortType LIMIT $this->limit")->fetchAll(PDO::FETCH_ASSOC);
    }
}