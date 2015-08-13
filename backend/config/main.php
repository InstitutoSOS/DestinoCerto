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
                'POST material' => 'material/create',
                'GET <controller>' => '<controller>/index',
                'GET <controller:\w+>/<id:\d+>' => '<controller>/view',
                'PUT <controller:\w+>/<id:\d+>' => '<controller>/update',
                'DELETE <controller:\w+>/<id:\d+>' => '<controller>/delete',
                

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
