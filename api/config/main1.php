<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php'


);
$config = [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'language' => 'ru',
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
    'modules' => [
        'v1' => [
            'class' => 'api\versions\v1\ApiModule',
            'components' => [
                'baseUser' => [
                    'class' => \api\versions\v1\components\user\BaseUserComponent::class,
                    'user_model' => \common\models\localRecord\User::class,
                    'api_formatter' => \api\versions\v1\models\requestModels\user\APIFormatter::class
                ],
                'user' => [
                    'class' => \api\versions\v1\components\user\UserComponent::class,
                    'user_model' => \common\models\localRecord\User::class,
                    'api_formatter' => \api\versions\v1\models\requestModels\user\APIFormatter::class
                ],
                'profile' => [
                    'class' => \api\versions\v1\components\user\ProfileComponent::class,
                    'user_model' => \common\models\localRecord\User::class,
                    'api_formatter' => \api\versions\v1\models\requestModels\user\APIFormatter::class
                ],
                'checkVerification' => [
                    'class'         => \api\versions\v1\components\CheckVerification::class,
                    'check'         => \api\versions\v1\models\requestModels\check\Check::class,
                    'api_formatter' => \api\versions\v1\models\requestModels\check\ApiFormatter::class
                ]
            ]
        ],

    ],
    'components' => [
        'user' => [
            'identityClass' => \common\models\localRecord\User::class,
            'enableSession' => false,
            'enableAutoLogin' => false,
        ],

        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://@localhost:27017/tax_check',
            'options' => [
                "username" => "jamal_diit",
                "password" => "5WnRmPSEW1"
            ],
        ],

        'requestCheck' => [
            'class' => \api\components\RequestCheck::class,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
        ],
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'baseUrl' => '/api',
        ],


        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['185.244.23.181', '176.120.213.118'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
