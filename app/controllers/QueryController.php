<?php


namespace App\controllers;

use App\Models\QueryModel;
use App\Models\TablesListModel;

class QueryController extends BaseController
{
    public function query()
    {
        $listTablesConnect = new TablesListModel();
        $listTables = $listTablesConnect->getList();

        $this->template = 'queryResult.html';
        $this->body = $this->request->getParsedBody();
        $queryConnect = new QueryModel();
        $queryContent = $queryConnect->query($this->body['q']);
        return [
            'list' => $listTables,
            'queryContent' => $queryContent,
        ];
    }
}