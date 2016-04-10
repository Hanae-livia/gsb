<?php

return [
    'settings' => [
        // false en prod
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'gsb',
            'username' => 'root',
            'password' => 'root',
            'charset'   => 'UTF8'
        ],
        'view' => [
            'template_path' => __DIR__ . '/src/View',
            'twig' => [
                //'cache' => __DIR__ . '/../cache/twig',
                'cache' => false,
                'debug' => true,
                'auto_reload' => true
            ]
        ]
    ]
];