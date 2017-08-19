<?php

namespace plupload\scripts;

class PluploadAssets extends \yii\web\AssetBundle
{
	public $sourcePath = '@vendor/plupload/yii2-plupload';
	#public $sourcePath = '@assets/tinymci/jscripts';
	#assets/tinymci/jscripts/tiny_mce/tiny_mce.js
	public $js = [
		'scripts/plupload.full.min.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\web\JqueryAsset',
	];
}
