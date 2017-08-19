<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 4:40 PM
 */

namespace app\components\widgets\plupload;

use yii;
use yii\web\AssetBundle;

class PluploadAssets extends AssetBundle{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	
    public function init(){
      $this->baseUrl = Yii::$app->params['sitehost'].'assets/plupload/js';
	   
    }


	public $js = [
        'plupload.full.min.js',
		'plupload_app.js',
		 
		
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
 

}