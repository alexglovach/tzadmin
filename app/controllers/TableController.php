<?php


namespace App\Controllers;
use App\Models\TableModel;


class TableController extends BaseController
{
    public function allTables() {
        $this->template = 'table.html';
        $this->getTablesList();

    }

    public function getData($table)
    {
        $this->template = 'table.html';

        // Sort
        $this->body = $this->request->getParsedBody();
        $queryParams = $this->request->getQueryParams();



        $connect = new TableModel();
        $listTables = $this->listTablesItems();




        if(isset($queryParams['to_table']) && !isset($queryParams['sort_by'])){
            $tableName = $queryParams['to_table'];
            $listTableColoumns = $connect->listColoumNames($tableName);
            $tableContent = $connect->tableContent($tableName);
        }else if(isset($queryParams['sort_by'])){
            $tableName = $queryParams['to_table'];
            $listTableColoumns = $connect->listColoumNames($tableName);
            $tableContent = $connect->tableSortBy($tableName,$queryParams['sort_by'],$queryParams['sort_type']);
        }else if(isset($this->body['q'])){
            $tableName = false;
            $listTableColoumns = false;
            $tableContent = $connect->directQuery($this->body['q']);
        }else{
            $tableName = false;
            $listTableColoumns = false;
            $tableContent = false;
        }
        if(isset($queryParams['sort_type']) && $queryParams['sort_type'] == 'DESC'){
            $sortType = 'ASC';
        }else{
            $sortType = 'DESC';
        }
        return [
            'currentTable'=>$tableName,
            'list' => $listTables,
            'tableHead' => $listTableColoumns,
            'tableContent' => $tableContent,
            'sortType' => $sortType,
        ];
    }

    private function getTablesList() {
        return $this->tablesListModel->getList();
    }
}