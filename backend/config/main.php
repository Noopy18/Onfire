<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
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
                ['class' => 'yii\rest\UrlRule','controller' => 'api/badge', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule','controller' => 'api/badge-utilizador', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule','controller' => 'api/category', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule','controller' => 'api/friends', 'pluralize' => false],
                ['class' => 'yii\rest\UrlRule','controller' => 'api/habit-completion', 'pluralize' => false],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/habit', 
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/completions' => 'completions',
                        'GET {id}/successrate' => 'successrate',
                        'GET {id}/canbecompleted' => 'canbecompleted',
                        'GET {id}/iscompleted' => 'iscompleted',
                        'GET {id}/duedate' => 'duedate',
                        'GET {id}/isfinished' => 'isfinished',
                        'GET {id}/getbeststreak' => 'getbeststreak',
                        'GET {id}/getstreak' => 'getstreak',
                        'GET {id}/getstreaks' => 'getstreaks',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule','controller' => 'api/user', 'pluralize' => false],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/utilizador', 
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/badges' => 'badges',
                        'GET {id}/habits' => 'habits',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule','controller' => 'api/weekly-challenge-completion', 'pluralize' => false],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/weekly-challenge',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/utilizadores' => 'utilizadores',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/weekly-challenge-utilizador', 
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}/completions' => 'completions',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
