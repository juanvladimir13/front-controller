<?php

/**
 * @author juanvladimir13 <juanvladimir13@gmail.com>
 * @see https://github.com/juanvladimir13
 */

declare(strict_types=1);

$endpoints = [
    'example' =>
        [
            'buscar' => 'example\/\d+\/name\/\w+',
            'listado' => 'example\/listado'
        ]
];

$httpRequestMethods = [
    'example.buscar' => [
        'GET' => [
            'function' => 'buscar',
            'urlParams' => ['id' => 1, 'name' => 3]
        ]
    ],
    'example.listado' => [
        'GET' => [
            'function' => 'listado'
        ]
    ]
];

$controllersNamespace = [
    'example' => 'FrontController\\Example'
];

return [
    'endpoint' => $endpoints,
    'httpRequestMethod' => $httpRequestMethods,
    'controllersNamespace' => $controllersNamespace
];
