<?php
$db = require_once ("db.php");
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'requestCheck' => [
            'class' => \api\components\RequestCheck::class,
        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://@localhost:27017/tax_check',
            'options' => [
                "username" => "jamal_diit",
                "password" => "5WnRmPSEW1"
            ],
        ],
        'db' => $db
    ],
];
