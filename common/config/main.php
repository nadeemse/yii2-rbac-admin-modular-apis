<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        's3bucket' => [
            'class' => \frostealth\yii2\aws\s3\Storage::className(),
            'region' => 'ap-southeast-1',
            'credentials' => [ // Aws\Credentials\CredentialsInterface|array|callable
                'key' => 'YOUR_AWS_KEY',
                'secret' => 'YOUR_AWS_SECRET',
            ],
            'bucket' => 'brrat-bucket',
            'cdnHostname' => 'http://example.cloudfront.net',
            'defaultAcl' => \frostealth\yii2\aws\s3\Storage::ACL_PUBLIC_READ,
            'debug' => false, // bool|array
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'dateTime' => [
            'class' => 'common\helpers\DateTimeHelper',
        ],
    ],
];
