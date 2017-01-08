<?php

/**
 * User modules routes
 * Example: [BASE_URL]/v1/user/auth
 * Above example showing that if you will access above route with base URL then AuthController Default function will run
 *
 * */
return [
    'user' => [
        'v1' => [
            // Oauth2
            'auth'   => [
                'controller'    => 'auth',
                'extraPatterns' =>
                    [
                        'POST <action:(.*)>'    => '<action>',
                        'OPTIONS <action:(.*)>' => 'options',
                    ],
            ],
            'account'   => [
                'controller'    => 'account',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>' => 'options',
                        'POST my-products' => 'my-items',
                        'GET verify' => 'verify',
                    ],
            ],
            'session'   => [
                'controller'    => 'session',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>' => 'options',
                        'POST login' => 'login', // Login request
                        'POST signup' => 'create', // signUp Request
                        'POST facebook-login' => 'facebook-login', // signUp Request
                        'POST forgot-password' => 'forgot-password', // signUp Request
                        'POST reset-password' => 'reset-password', // reset password
                    ],
            ],
            'client' => [
                'controller' => 'client',
                'extraPatterns' =>
                    [
                        'OPTIONS <action:(.*)>' => 'options',
                        'GET find-client/{app_id}' => 'find-client',
                    ],
            ],
            'scope'  => [
                'controller' => 'scope',
            ],
        ],
        'v2' => [
            'inherit-from' => 'v1',
        ],
    ],
];
