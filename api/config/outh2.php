<?php

return [
    'class'               => 'filsh\yii2\oauth2server\Module',
    'tokenParamName'      => 'token',
    'tokenAccessLifetime' => 3600 * 28, //getenv('tokenAccessLifetime'),// 28 days  3600 * 28,
    'storageMap'          => [
        'user_credentials' => 'common\models\OauthUser', // USer has Outh_users
    ],
    'grantTypes'          => [
        'client_credentials' => [
            'class'                => 'OAuth2\GrantType\ClientCredentials',
            'allow_public_clients' => false,
        ],
        'user_credentials'   => [
            'class' => 'OAuth2\GrantType\UserCredentials',
        ],
        'refresh_token'      => [
            'class'                          => 'OAuth2\GrantType\RefreshToken',
            'always_issue_new_refresh_token' => true,
            'refresh_token_lifetime'         => 3600 * 28, //'100800',getenv('tokenAccessLifetime'),
        ],
    ],
];