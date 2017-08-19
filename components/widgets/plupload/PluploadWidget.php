<?php
namespace app\components\widgets\plupload;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;


class PluploadWidget extends Widget
{
	    public $tableName = '';
		public $tableid = '';
		 
	    public function init()
		{
			
		PluploadAssets::register($this->getView());
	
      	$this->getView()->registerJs('');

	    }
	     
	    public function run()
		{
			 
			$data = (new \yii\db\Query())->from('image')->where([ 'name' => $this->tableName , 'tableid' => $this->id ])->orderBy('order')->all();
			
	        return   $this->render( '@app/components/widgets/plupload/views/filebox',['files' =>$data ]);
	    }
}