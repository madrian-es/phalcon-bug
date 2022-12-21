<?php
$router = new Phalcon\Mvc\Router();

$router->removeExtraSlashes(true);

/*
$router->addGet('/user/:int/impersonation',[
    'controller' => 'user',
    'action'     => 'impersonation',
    'user_id'    => 1
]);*/

$router->addPost('/api/token', [
    'namespace'   => 'App\Controllers\Api',
    'controller'  => 'token',
    'action'      => 'parseToken',
]);

return $router;
