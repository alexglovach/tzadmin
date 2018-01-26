<?php


namespace App\controllers;

class QueryController extends BaseController
{
    public function query()
    {
        $this->template = 'queryResult.html';
        $this->body = $this->request->getParsedBody();
        return [
            'list' => $this->tablesListModel->getList(),
            'queryContent' => $this->queryModel->query($this->body['q']),
        ];
    }
}