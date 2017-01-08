<?php

/**
 * Information modules routes
 * Example: [BASE_URL]/v1/information/page
 * Above example showing that if you will access above route with --
 * base URL then v1/controllers/PageController Default function will run
 *
 * */
return [
    'information' => [
        'v1' => [
            'page' => [
                'controller'    => 'page',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                        'GET view/{slug}' => 'view'
                    ],
            ],
        ],
        'v2' => [
            'inherit-from' => 'v1',
        ],
    ],
];
