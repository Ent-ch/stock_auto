<?php
use \kartik\datecontrol\Module;

Yii::$container->set(\Zelenin\yii\modules\RequestLog\behaviors\RequestLogBehavior::className(), [
    'excludeRules' => [
        function () {
            list ($route, $params) = Yii::$app->getRequest()->resolve();
            return $route === 'debug/default/toolbar';
        }
    ]
]);

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Europe/Kiev',
    'language' => 'ru',
    'sourceLanguage' => 'en_US',
//	'enableSchemaCache' => true,
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'chLUBv29-mcEJ1JBUDG-Iv8i1OVssfGb',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
/*            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true, */
			'class' => 'amnah\yii2\user\components\User',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
			'messageConfig' => [
                'from' => ['admin@website.com' => 'Admin'], // this is needed for sending emails
                'charset' => 'UTF-8',
            ],
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
        'db' => require(__DIR__ . '/db.php'),
		
        'i18n'=>array(
            'translations' => array(
                'main*'=>array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@app/messages",
                    'sourceLanguage' => 'en_US',
                    'fileMap' => array(
                        'app' => 'app.php', 
                    )
				),
                'zelenin*'=>array(
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@app/messages",
                    'sourceLanguage' => 'en_US',
                    'fileMap' => array(
                        'zelenin/modules/request-log' => 'modules.php', 
                    ),                    
                ),
            )
        ),
        
       'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'dateFormat' => 'dd.MM.y',
			'datetimeFormat' => 'php:d.m.Y H:i:s',
			'timeFormat' => 'php:H:i:s',
		],

    ],
    
	 'controllerMap' => [
        'file' => 'mdm\\upload\\FileController', // use to show or download file
    ], 
	
	'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
        ],
	   'datecontrol' =>  [
		   'class' => 'kartik\datecontrol\Module',
 
			'displaySettings' => [
				Module::FORMAT_DATE => 'dd.MM.y',
				Module::FORMAT_TIME => 'HH:mm:ss a',
				Module::FORMAT_DATETIME => 'dd.MM.y HH:mm:ss a', 
			],

			// format settings for saving each date attribute (PHP format example)
			'saveSettings' => [
				Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
				Module::FORMAT_TIME => 'php:H:i:s',
				Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
			],

		   // automatically use kartik\widgets for each of the above formats
			'autoWidget' => true,

			// default settings for each widget from kartik\widgets used when autoWidget is true
			'autoWidgetSettings' => [
				Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
				Module::FORMAT_DATETIME => [], // setup if needed
				Module::FORMAT_TIME => [], // setup if needed
			],
        
		],
        'request-log' => [
            'class' => Zelenin\yii\modules\RequestLog\Module::className(),
            // username attribute in your identity class (User)
            'usernameAttribute' => 'email'
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
	],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['bootstrap'][] = 'gii';
    $config['modules']['debug']  = 
		[
		 'class' => 'yii\debug\Module',
		 'allowedIPs' => ['*']
    	];
    $config['modules']['gii'] = 
		[
		 'class' => 'yii\gii\Module',
		 'allowedIPs' => ['*']
    	];
}

return $config;
