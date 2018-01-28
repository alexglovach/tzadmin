<?php


namespace App\Models;
use PDO;

class QueryModel extends BaseModel
{
    public function query($query)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

}