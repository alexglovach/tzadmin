<?php


namespace App\Controllers;

class TableController extends BaseController
{
    public function allTables()
    {
        $this->template = 'allTables.html';
        return [
            'list' => $this->tablesListModel->getList()
        ];
    }

    public function getData($tableName)
    {
        $this->template = 'table.html';


        $this->body = $this->request->getParsedBody();
        $queryParams = $this->request->getQueryParams();
        $listTables = $this->tablesListModel->getList();

        $sort = isset($queryParams['sort_by']) ? $queryParams['sort_by'] : 'id';
        $asc = isset($queryParams['sort_type']) ? $queryParams['sort_type'] : 'ASC';
        $tableContent = $this->tableModel->tableContent($tableName, $sort, $asc);

        if ($asc != 'DESC') {
            $sortType = 'DESC';
        } else {
            $sortType = 'ASC';
        }

        return [
            'currentTable' => $tableName,
            'list' => $listTables,
            'tableContent' => $tableContent,
            'sortType' => $sortType,
        ];
    }
}