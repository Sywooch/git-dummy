<?php
namespace app\modules\system\widgets\view;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\system\models\TextWidget;


class ViewWidget extends Widget
{
	    public $code = '';
		public $tpl = '';
	
		
	 	public function run()
		{
			 $data = $this->get( [ 'alias' => $this->code ] );
			 
	        return   $this->render( '@app/views/'.$this->tpl,
					[
					'data' =>$data 
					]
					);
	    }
		
		public function get($where)
		{
			 
			return TextWidget::find()->where($where)->one();
		}
}