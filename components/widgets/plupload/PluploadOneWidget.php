<?php
namespace app\components\widgets\plupload;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;


class PluploadOneWidget extends Widget
{
	    public $tableName = '';
		public $tableid = '';
		 
	    public function init()
		{
			
		PluploadOneAssets::register($this->getView());
	
      	$this->getView()->registerJs('');

	    }
	     
	    public function run()
		{
	        return   $this->render( '@app/components/widgets/plupload/views/one');
	    }
}