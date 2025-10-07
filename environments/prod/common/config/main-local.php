<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'pgsql:host=localhost;dbname=yiivian',
            'username' => 'yiivian',
            'password' => '',
            'charset' => 'utf8',
            'enableQueryCache' => true,
            'queryCacheDuration' => 5,
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 30,
            'schemaCache' => 'cache',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ],
];
