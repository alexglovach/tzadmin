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

    public function getData($tableName,$pagination = 1)
    {
        $this->template = 'table.html';


        $this->body = $this->request->getParsedBody();
        $queryParams = $this->request->getQueryParams();
        $listTables = $this->tablesListModel->getList();

        $sort = isset($queryParams['sort_by']) ? $queryParams['sort_by'] : 'id';
        $asc = isset($queryParams['sort_type']) ? $queryParams['sort_type'] : 'ASC';
        $tableContent = $this->tableModel->tableContent($tableName, $sort, $asc, $pagination);
        if($pagination == 1){
            $pag = $pagination + 1;
            $nextLink = "/table/$tableName/page/$pag";
            $previosLink = false;
        }elseif($tableContent[1] == true){
            $nextLink = false;
            $pag = $pagination - 1;
            $previosLink = "/table/$tableName/page/$pag";
        }else{
            $pag = $pagination + 1;
            $nextLink ="/table/$tableName/page/$pag";
            $pag = $pagination - 1;
            $previosLink = "/table/$tableName/page/$pag";
        }



        if ($asc != 'DESC') {
            $sortType = 'DESC';
        } else {
            $sortType = 'ASC';
        }
        return [
            'currentTable' => $tableName,
            'list' => $listTables,
            'tableContent' => $tableContent[0],
            'sortType' => $sortType,
            'currentPage' => $pagination,
            'nextLink' => $nextLink,
            'previosLink' => $previosLink,
        ];
    }
}