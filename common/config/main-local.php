<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=yii2test',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        /*'mongodb' => [
            'class' => 'yii\mongodb\Connection',
            'dsn'=> 'mongodb://localhost/database?connectTimeoutMS=300000',
            'defaultDatabaseName' => 'yii2_admin_mongo_db', // Avoid autodetection of default database name
        ],*/
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'htmlLayout' => '@common/mail/layouts/html',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'YOU_GMAIL_ADDRESS',
                'password' => 'YOUR_PASSWORD',
                'port' => '465', // Port 25 is a very common port too
                'encryption' => 'ssl', // It is often used, check your provider or mail server specs
            ],
        ],
    ],
];
