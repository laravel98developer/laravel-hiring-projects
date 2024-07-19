<?php

namespace Amir\Todolist;

use \Amir\Todolist\Controllers\TaskController;
use Amir\Todolist\Request\Request;
use Amir\Todolist\Request\Router;

$router = new Router(new Request);

$router->get('/^\/tasks/', [
    TaskController::class,
    'getAll'
]);

$router->post('/^\/tasks$/', [
    TaskController::class,
    'create'
]);

$router->patch('/^\/tasks\/(?P<task_id>.+)$/', [
    TaskController::class,
    'update'
]);
