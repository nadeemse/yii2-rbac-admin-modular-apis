<?php

/**
 * Catalog modules routes
 * Example: [BASE_URL]/v1/catalog/category
 * Above example showing that if you will access above route with base URL then CategoryController Default function will run
 *
 * */

return [
    'catalog' => [
        'v1' => [
            'category' => [
                'controller'    => 'category',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ],
            'item' => [
                'controller'    => 'item',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'     => 'options',
                        'GET view-slug'          => 'view-by-slug',
                        'GET view'          => 'view',
                        'POST item-list'          => 'item-list',
                        'PATCH update'         => 'update',
                    ],
            ],
            'media' => [
                'controller'    => 'media',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ],
        ],
        'v2' => [
            'inherit-from' => 'v1',
        ],
    ],
];
