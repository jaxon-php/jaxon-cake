<?php

return [
    'app' => [
        'request' => [
            // 'route' => 'jaxon',
        ],
        'classes' => [
            [
                'directory' => rtrim(ROOT, '/') . '/jaxon/Classes',
                'namespace' => '\\Jaxon\\App',
                // 'separator' => '', // '.' or '_'
                // 'protected' => [],
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'language' => 'en',
            'encoding' => 'UTF-8',
            'request' => [
                'uri' => 'jaxon',
            ],
            'prefix' => [
                'class' => '',
            ],
            'debug' => [
                'on' => false,
                'verbose' => false,
            ],
            'error' => [
                'handle' => false,
            ],
        ],
        'js' => [
            'lib' => [
                // 'uri' => '',
            ],
            'app' => [
                // 'uri' => '',
                // 'dir' => '',
                // 'export' => true,
                // 'minify' => true,
            ],
        ],
    ],
];
