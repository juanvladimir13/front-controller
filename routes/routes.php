<?php

/**
 * @author juanvladimir13 <juanvladimir13@gmail.com>
 * @see https://github.com/juanvladimir13
 */

declare(strict_types=1);

return [
    'paciente' => [
        'className' => 'CPaciente',
        'namespace' => 'ConsultorioBebito\Controllers',
        'endpoints' => [
            'GET' => [
                [
                    'url' => 'listado',
                    'endpoint' => 'index'
                ]
            ],
            'POST' => [
                [
                    'url' => '',
                    'endpoint' => 'store'
                ]
            ]
        ],
    ],
    '' => [
        'className' => 'CHome',
        'namespace' => 'ConsultorioBebito\Controllers',
        'endpoints' => [
            'GET' => [
                [
                    'url' => '',
                    'endpoint' => 'index'
                ]
            ]
        ],
    ]
];
