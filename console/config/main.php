<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@api' => dirname(dirname(__DIR__)) . "/api",
        '@data' => dirname(dirname(__DIR__)) . "/api/web/data",
        '@common' => dirname(dirname(__DIR__)) . "/common",
        '@backend' => dirname(dirname(__DIR__)) . "/backend",
        '@frontend' => dirname(dirname(__DIR__)) . "/frontend",
        '@console' => dirname(dirname(__DIR__)) . "/console",
        '@uploads' => dirname(dirname(__DIR__)) . "/uploads",
    ],

    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
        'mongodb-migrate' => [
            'class' => 'yii\mongodb\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'console\mgmigrations',
            ],
            'migrationPath' => '@console/mgmigrations',
        ]
    
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=127.0.0.1;port=5432;dbname=tax',
            'username' => 'tax_admin',
            'password' => 'JqP7xqs8m4',
            'charset' => 'utf8'
        ],
        'mongodb-migrate' => [
            'class' => 'yii\mongodb\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'console\mgmigrations',
            ],
            'migrationPath' => '@console/mgmigrations',
        ]



    ],
    'params' => $params,
];
