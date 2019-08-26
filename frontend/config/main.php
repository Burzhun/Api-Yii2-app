<?php
$db = require '../../common/config/db.php';
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'  => 'ru_RU',
    'name'      => 'Деловой дагестан',
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => '/',
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
    'components' => [
        'check' => [
            'class' => \frontend\components\CheckComponent::class,
            'model' => \frontend\models\CheckForm::class
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from' => 'absalimov98@bk.ru' // sender address goes here
            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'viewPath' => '@common/mail',
            'htmlLayout' => 'layouts/html',
            'useFileTransport' => false,
            'transport' => [
                'class'     => 'Swift_SmtpTransport',
                'host'      => 'smtp.mail.ru.',
                'username'  => 'absalimov98@bk.ru',
                'password'  => 't6jx4jdn!',
                'port'      => '465',
                'encryption' => 'ssl',
            ]
        ],
        'db' => $db,
        'user' => [
            'identityClass' => 'common\models\localRecord\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

    ],
    'params' => $params,
];
