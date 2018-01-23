<?php return [
    'mysql' => function ($env) {
        $db = new \App\Models\BaseModel($env['mysql']);
        return $db;
    },

    'tableModel' => function ($env, $container) {
        return new \App\Models\TableModel();
    },

    'tablesListModel' => function ($env, $container) {
        return new \App\Models\TableModel();
    },


    'queryModel' => function ($env, $container) {
        return new \App\Models\TableModel();
    },
];
