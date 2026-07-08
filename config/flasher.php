<?php

use Flasher\Prime\Configuration;

return Configuration::from([
    'default' => 'flasher',

    'main_script' => '/vendor/flasher/flasher.min.js',

    'public_path' => '',

    'styles' => [
        '/vendor/flasher/flasher.min.css',
    ],

    'inject_assets' => true,

    'translate' => true,

    'excluded_paths' => [],

    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

    'filter' => [
        'limit' => 3,
    ],

    'presets' => [
        'dbCreated' => [
            'type' => 'success',
            'message' => 'El registro ha sido creado con exito.',
            'title' => 'Exito',
        ],
        'dbUpdated' => [
            'type' => 'info',
            'message' => 'El registro ha sido actualizado con exito.',
            'title' => 'Actualizado',
        ],
        'dbDeleted' => [
            'type' => 'error',
            'message' => 'El registro ha sido eliminado con exito.',
            'title' => 'Eliminado',
        ],
    ],
]);
