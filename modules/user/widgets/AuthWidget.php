<?php
namespace app\modules\user\widgets;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\models\User;


class AuthWidget extends Widget
{

		
	 	public function run()
		{
			 $data = $this->get( [ 'id' => yii::$app->user->getId() ] );
			 
	        return   $this->render( '@app/views/widgets/auth',	[
					'data' =>$data		]
					);
	    }
		
		public function get($where)
		{
			 
			return User::find()->where($where)->one();
		}
}