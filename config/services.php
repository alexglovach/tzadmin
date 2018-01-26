<?php return [
    'tableModel' => function ($env, $container) {
        return new \App\Models\TableModel($env['mysql']);
    },

    'tablesListModel' => function ($env, $container) {
        return new \App\Models\TablesListModel($env['mysql']);
    },


    'queryModel' => function ($env, $container) {

        return new \App\Models\QueryModel($env['mysql']);
    },
];
