<?php

list($restRoutes, $restRoutesVersion) = require(__DIR__ . '/api-routes.php');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'settings' => [
            'class' => 'api\modules\settings\Module'
        ],
        'user' => [
            'class' => 'api\modules\user\Module'
        ],
        'catalog' => [
            'class' => 'api\modules\catalog\Module'
        ],
        'information' => [
            'class' => 'api\modules\information\Module'
        ],
        'oauth2' => require(__DIR__ . '/outh2.php')
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'class' => 'api\core\components\web\ErrorHandler'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request'      => [
            'class'   => 'api\core\components\web\Request',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response'     => [
            'class'         => 'api\core\components\web\Response',
            'formatters'    => [
                \yii\web\Response::FORMAT_HTML => '\api\core\components\web\HtmlResponseFormatter',
                \yii\web\Response::FORMAT_JSON => '\api\core\components\web\JsonResponseFormatter',
            ],
            'on beforeSend' => function (\yii\base\Event $event) {
                api\core\components\web\Response::negotiateContentBeforeSend($event);
            },
        ],
        'urlManager' => [
            'class'           => 'api\core\components\web\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => $restRoutes,
            'routesVersion' => $restRoutesVersion
        ]
    ],
    'params' => $params,
];



