<?php

 

$params_change = require(__DIR__ . '/params_change.php');

$params  = [
        'redirectAuth' => 'admin/index',
		'sitehost' => 'http://'.$_SERVER['HTTP_HOST'].'/',
		'imagePath' =>'http://'.$_SERVER['HTTP_HOST'].'/files/',
        'availableLocales'=>
		[
            'en-US'=>'English (US)',
            'ru-RU'=>'Русский (РФ)',
            'uk-UA'=>'Українська (Україна)'
        ],
		 
		 
];


return  yii\helpers\ArrayHelper::merge($params, $params_change);