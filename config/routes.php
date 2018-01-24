<?php return [
    ['GET', '/', \App\Controllers\TableController::class, 'allTables'],
    ['GET', '/table/{name}', \App\Controllers\TableController::class, 'getData'],
    ['POST', '/query', \App\Controllers\QueryController::class, 'query'],
];