<?php

return [
    'db' => [
        'host' => "localhost",
        'dbname' => 'rickandmorty',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // ассоциативный массив
        ]
    ],
    'per_page' => 5,
];