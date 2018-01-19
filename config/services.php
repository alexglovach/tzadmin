<?php return [
    'mysql' => function ($env) {
        $db = new \App\Models\BaseModel($env['mysql']);
        return $db;
    },

    'queue' => function ($env) {
        $connection = new \AMQPConnection($env['rabbitmq']);
        $connection->connect();
        $channel = new \AMQPChannel($connection);
        return new \App\Helpers\Queue($channel);
    },

    'ListTablesModel' => function ($env, $container) {
        $db = $container->get('mysql');
        return new \App\Models\ListTablesModel($db);
    }
];
