<?php

/**
 * Settings modules routes
 * Example: [BASE_URL]/v1/settings/page
 * Above example showing that if you will access above route with base URL then PageController Default function will run
 *
 * */
return [
    'settings' => [
        'v1' => [
            'page' => [
                'controller'    => 'page',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ],
            'country' => [
                'controller'    => 'country',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ],
            'age' => [
                'controller'    => 'age',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ],
            'condition' => [
                'controller'    => 'condition',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ],
            'uses' => [
                'controller'    => 'uses',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ],
            'cities' => [
                'controller'    => 'cities',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ],
            'areas' => [
                'controller'    => 'areas',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>'    => 'options',
                    ],
            ]
        ],
        'v2' => [
            'inherit-from' => 'v1',
        ],
    ],
];
