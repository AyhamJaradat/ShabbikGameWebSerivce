<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Api
        ['class' => 'yii\rest\UrlRule',
            'controller' => 'api/v1/article',
            'only' => ['index', 'view', 'options']
        ],
        ['class' => 'yii\rest\UrlRule',
            'controller' => 'v1/service',
            'pluralize' => false,
        ],
    ]
];
