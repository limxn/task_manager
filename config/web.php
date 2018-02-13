<?php

$params = require __DIR__ . '/params.php';

$db = \yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/db.php',
    require __DIR__ . '/db_local.php'
);
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language'=>'ru-RU',
    'bootstrap' => [
        'log',
        'app\bootstrap\Bootstrap'
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'KZUGITo8gMUxQbTLWkip_XmGa-UL5xlE',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => \app\decorators\UserIdentityDecorator::class,
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/login']
        ],
        'errorHandler' => [
            'errorAction' => 'error/index',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'project/index',
                '<_a:login|logout>' => 'auth/<_a>',
                'registration' => 'registration/index',
                'project/<project_id:\d+>/user/create' => 'project-user/create',
                'project/<project_id:\d+>/users' => 'project-user/index',
                'project/<project_id:\d+>/user/admin' => 'project-user/admin',
                'project/<project_id:\d+>/task/create' => 'task/create',
                'project/<project_id:\d+>/task/<task_id:\d+>' => 'task/view',
                'project/<project_id:\d+>/task/<task_id:\d+>/<_a:delete|update>' => 'task/<_a>',
                'project/<project_id:\d+>/tasks' => 'task/index',
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<id:\d+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['auth/login','error/index','registration/index'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
