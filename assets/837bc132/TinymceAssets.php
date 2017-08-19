<?php

namespace letyii\tinymce;

class TinymceAssets extends \yii\web\AssetBundle
{
	public $sourcePath = '@vendor/letyii/yii2-tinymce';
	#public $sourcePath = '@assets/tinymci/jscripts';
	#assets/tinymci/jscripts/tiny_mce/tiny_mce.js
	public $js = [
		'tiny_mce/tiny_mce.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
	];
}
