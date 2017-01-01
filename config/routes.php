<?php

use Cake\Routing\Router;

try
{
    // This call throws an exception if the named route is not found.
    $url = Router::url(['_name' => 'jaxon']);
}
catch(\Exception $e)
{
    // The route is added only if no route with the same name already exists.
    Router::plugin('Jaxon/Cake', ['path' => '/jaxon'], function ($routes) {
        $routes->connect('/', ['controller' => 'Jaxon', 'action' => 'index'], ['_name' => 'jaxon']);
    });
}
