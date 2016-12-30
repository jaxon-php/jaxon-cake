<?php

use Cake\Routing\Router;

Router::plugin('Jaxon/Cake', ['path' => '/jaxon'], function ($routes) {
    $routes->connect('/', ['controller' => 'Jaxon', 'action' => 'index']);
});
