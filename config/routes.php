<?php

use Cake\Routing\RouteBuilder;
use Jaxon\Cake\Middleware\AjaxMiddleware;
use Jaxon\Cake\Middleware\ConfigMiddleware;

$routes->plugin(
    'Jaxon/Cake',
    ['path' => '/ajax'],
    function ($routes) {
        $routes->scope('/', function (RouteBuilder $builder) {
            $builder->registerMiddleware('jaxon.config', new ConfigMiddleware());
            $builder->registerMiddleware('jaxon.ajax', new AjaxMiddleware());

            // Jaxon ajax middlewares and route.
            $builder->applyMiddleware('jaxon.config');
            $builder->applyMiddleware('jaxon.ajax');
    
            $builder->post('/', ['controller' => 'Jaxon', 'action' => 'jaxon', '_name' => 'jaxon']);
        });
    }
);
