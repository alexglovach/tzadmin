<?php


namespace App\Controllers;
use App\Models\HomeModel;


class HomeController extends BaseController
{
    public function home()
    {
        $connect = new HomeModel();
        $listTables = $connect->listTablesItems();

        $this->body = $this->request->getParsedBody();
        $queryParams = $this->request->getQueryParams();

        $this->template = 'home.html';


        if (isset($this->body['q'])) {
            $result = $this->body['q'];
        } else {
            $result = false;
        }

        if(isset($queryParams['to_table']) && !isset($queryParams['sort_by'])){
            $tableName = $queryParams['to_table'];
            $listTableColoumns = $connect->listColoumNames($tableName);
            $tableContent = $connect->tableContent($tableName);
        }else if(isset($queryParams['sort_by'])){
            $tableName = $queryParams['to_table'];
            $listTableColoumns = $connect->listColoumNames($tableName);
            $tableContent = $connect->tableSortBy($tableName,$queryParams['sort_by'],$queryParams['sort_type']);
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
            'result' => $result,
            'tableHead' => $listTableColoumns,
            'tableContent' => $tableContent,
            'sortType' => $sortType,
        ];
    }
}