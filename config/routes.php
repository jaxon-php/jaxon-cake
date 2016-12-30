<?php

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\Router;

Router::plugin(
    'Jaxon',
    ['path' => '/jaxon'],
    function ($routes) {
        // $routes->fallbacks(DashedRoute::class);
    }
);
