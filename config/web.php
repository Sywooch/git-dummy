<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
	
    'bootstrap' => ['log'],
	
	'vendorPath'=>dirname(__DIR__).'/vendor',
    'extensions' => require(dirname(__DIR__) . '/vendor/yiisoft/extensions.php'),
	
	'sourceLanguage'=>'ru',
    'language'=>'en',
	
	'defaultRoute' => 'site/index',
	
	'modules' => [
      /*  'merchant' => [
            'class' => 'app\modules\merchant\Module',
        ],
			'backup' => [
                'class' => 'spanjeta\modules\backup\Module',
            ],*/
			'shop' => [
					'class' => 'app\modules\shop\Module',
			],
            'tickets' => [
                'class' => 'app\modules\tickets\Module',
            ],
            'user' => [
                'class' => 'app\modules\user\Module',
            ],
			'terms' => [
                'class' => 'app\modules\terms\Module',
            ],
			'system' => [
                'class' => 'app\modules\system\Module',
            ],
			'seo' => [
                'class' => 'app\modules\seo\Module',
            ],
			'staticpage' => [
                'class' => 'app\modules\staticpage\Module',
            ],
			 'news' => [
                'class' => 'app\modules\news\Module',
            ],
			'catalog' => [
                'class' => 'app\modules\catalog\Module',
            ],
			'menu' => [
                'class' => 'app\modules\menu\Module',
            ],
			'gallery' => [
                'class' => 'app\modules\gallery\Module',
            ],

        ],
	
	 'controllerMap'=>[
            'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            
			'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            
			'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
			 
            'roots' => [
                [
                    'baseUrl'=>'',
                    'basePath'=>'@app',
                    'path' => 'files',
                    'name' => 'Files'
                ],
				
                
            ]
        ]
        ],
    'components' => [

       /* 'pm' => [
            'class' => '\app\modules\merchant\models\PerfectMoney',
            'accountId' => '6361371',
            'accountPassword' => '&t$8lzYBr6',
            'walletNumber' => 'U10188882',
            'merchantName' => 'callangel.biz',
            'alternateSecret' => '4558oJV5AbxUQwsMTcxgPcsTA',
            'resultUrl' => [ '/merchant/perfect-money/result'],
            'successUrl' => ['/merchant/perfect-money/success'],
            'failureUrl' => ['/merchant/perfect-money/failure'],
        ],

        echo \app\modules\merchant\widgets\perfectmoney\RenderForm::widget([
        'api' => Yii::$app->pm,
        'invoiceId' => yii::$app->user->getId(),
        'amount' => $_GET['amount'],
        'description' => 'Пополнение внутреннего счета',
        'autoRedirect' => true,
    ]);

       */

			'view' => [
					'class' => '\app\components\ViewCompress',
					'compress' => false,///YII_ENV_DEV ? false : true,

			],


		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'dateFormat' => 'dd-MM-Y',
			'datetimeFormat' => 'dd-MM-Y H:i',
			'timeFormat' => 'H:i:s',
		], 
		
		 
		  
	  	 
		 
		'urlManager' => [
        'class' => 'yii\web\UrlManager',
        'enablePrettyUrl' => true,
        'showScriptName' => false,
		 
		'baseUrl' => '',
        'rules' => [
             'sitemap.xml'                => 'site/sitemap',
             'add-bit'                    =>'auct/addbit',
			 'search'                     =>'product/search',
			 '<url:[\w-]+>.html'          => 'page/view',
             '/product/zoomer' 				  => 'product/zoomer',
			 '/product/<url:[\w-]+>.html' => 'product/view',
             '/product' 				  => 'product/list',

             '/popular' 				  => 'product/ajaxpopular',
             '/morereviews' 				  => 'product/morereviews',
             '/subcat' 				      => 'product/subcat',
             '/typethread' 				  => 'product/typethread',
             '/faq/<url:[\w-]+>' 		  => 'pnews/faq',
             '/faq' 		    		  => 'pnews/faq',


			 '/product/<url:[\w-]+>'      => 'product/list',

			 '/gallery' 				  => 'pgallery/index',
			 '/gallery/<url:[\w-]+>' 	  => 'pgallery/view',
			 
			 '/news/<url:[\w-]+>.html'    => 'pnews/view',
			 '/news'                      => 'pnews/list',
			 '/news/<url:[\w-]+>'         => 'pnews/list',
			 
			 '/contacts'                  => 'contacts/index',
			# '/news/<url:[\w-]+>/<page:[\d]+>' => 'pnews/list/page/<page>',

				'add-to-basket' => 'pshop/add',
				'checkout'      => 'pshop/checkout',
				'checkout-end'      => 'pshop/checkout',
				'basket-history'  => 'pshop/history',
				'delete-from-basket'      => 'pshop/delete_item',
				'change-count-basket'   => 'pshop/change_item',

             
			 '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
			 '<controller:\w+>/<action:\w+>'              => '<controller>/<action>',
             '<controller:\w+>/<action:\w+>/<id:\d+>'     => '<controller>/<action>',
             
       			 ],
   		 ],
		 
		 
		'i18n' => [
			'translations' => [
				'app' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@app/messages',
					'fileMap' => [
						'app' => 'frontend.php',
						
					],
				],
				'admin*' => 
				[
					'basePath' => '@app/messages',	
					'class' => 'yii\i18n\PhpMessageSource',
					'fileMap' => 
					['admin*' => 'admin.php'],
				],
			],
		],
        'request' => [
            'class'=>'app\components\Request',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'oazUCKHEN7E-PuPISgKQK9PUp7D1BtvG',
			'baseUrl' => '/',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
    ],
    'params' => $params,
];
/*
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}*/

return $config;
