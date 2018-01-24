<?php


namespace App\Controllers;

use App\Models\TablesListModel;
use App\Models\TableModel;


class TableController extends BaseController
{
    public function allTables() {
        $this->template = 'allTables.html';
        $listTables = new TablesListModel();
        return [
            'list' => $listTables->getList(),
        ];
    }

    public function getData()
    {

        $this->body = $this->request->getParsedBody();
        $queryParams = $this->request->getQueryParams();
        $tableName = str_replace('/table/','',$_SERVER['REQUEST_URI']);
        $connect = new TableModel();
        $listTables = $this->allTables()['list'];
        $this->template = 'table.html';
        if(!isset($queryParams['sort_by'])){
            $tableContent = $connect->tableContent($tableName);
        }else{
            preg_match('/(.*)\?/',$tableName,$tableName);
            $tableName = $tableName[1];
            $tableContent = $connect->tableSortBy($tableName,$queryParams['sort_by'],$queryParams['sort_type']);
        }
        if(isset($queryParams['sort_type']) && $queryParams['sort_type'] == 'DESC'){
            $sortType = 'ASC';
        }else{
            $sortType = 'DESC';
        }
        if(!count($tableContent)){
            $tableContent = false;
        }
        return [
            'currentTable' => $tableName,
            'list' => $listTables,
            'tableContent' => $tableContent,
            'sortType' => $sortType,
        ];
    }

    private function getTablesList() {
        return $this->tablesListModel->getList();
    }
}