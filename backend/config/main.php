<?php
$db = require '../../common/config/db.php';
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config =  [
    'id'                    => 'app-backend',
    'basePath'              => dirname(__DIR__),
    'controllerNamespace'   => 'backend\controllers',
    'name'                  => 'Tax',
    'timeZone'              => 'Europe/Moscow',
    'language'              => 'ru-RU',
    'bootstrap'             => ['log'],
    'modules'               => [],
    'homeUrl'               => '/admin',
    'components' => [
        'request' => [
            'csrfParam'     => '_csrf-backend',
            'baseUrl'       => '/admin'
        ],
        'user' => [
            'identityClass'     => 'common\models\localRecord\User',
            'enableAutoLogin'   => true,
            'identityCookie'    => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'db' => $db,
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'     => 'yii\log\FileTarget',
                    'levels'    => ['error', 'warning'],
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
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://@localhost:27017/tax_check',
            'options' => [
                "username" => "jamal_diit",
                "password" => "5WnRmPSEW1"
            ],
        ],

    ],
    'params' => $params,
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}
return $config;
