<?php


namespace App\controllers;


class QueryController extends BaseController
{
    public function query()
    {
        $this->template = 'queryResult.html';
        $this->body = $this->request->getParsedBody();
        $queryParams = $this->request->getQueryParams();
        //var_dump('<pre>',$this->body);


        return [
            'tableHead' => $listTableColoumns,
            'tableContent' => $tableContent,
            'sortType' => $sortType,
        ];
    }
}