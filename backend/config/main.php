<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$folder = explode('/', $_SERVER['REDIRECT_URL'])[1];
$baseUrl = '/api';
 
return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'homeUrl'  => '/api',
    'modules' => [],
    'components' => [
        'urlManager' => [
            'baseUrl' => '/api',
            'rules' => [
                'POST user/login' => 'user/login',
                'GET <controller>' => '<controller>/index',
                'POST <controller>' => '<controller>/create',
                'GET <controller>/<id>' => '<controller>/view',
                'GET <controller>/<id>/<action>' => '<controller>/<action>',
                'PUT <controller>/<id>' => '<controller>/update',
                'DELETE <controller>/<id:\d+>' => '<controller>/delete',

                'POST user/login/' => 'user/login',
                'GET <controller>/' => '<controller>/index',
                'POST <controller>/' => '<controller>/create',
                'GET <controller>/<id>/' => '<controller>/view',
                'GET <controller>/<id>/<action>' => '<controller>/<action>',
                'PUT <controller>/<id>/' => '<controller>/update',
                'DELETE <controller>/<id:\d+>/' => '<controller>/delete',
                

            ],
            'enableStrictParsing' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'request'=>[
            'baseUrl'=>'/api',
             'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
    ],
    'params' => $params,
];
