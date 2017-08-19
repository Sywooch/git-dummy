<?php
namespace app\modules\gallery\widgets;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\gallery\models\Gallery;


class ViewWidget extends Widget
{
	    public $catid = '';
		public $tpl = '';
	
		
	 	public function run()
		{
			
			if( $this->catid )
				$data = $this->get( [ 'gallerycatid' => $this->catid ] );
			 else
			 	$data = $this->get( '' );
				
			 
	        return   $this->render( '@app/views/'.$this->tpl,
					[
					'data' =>$data 
					]
					);
	    }
		
		public function get($where)
		{
            if(\Yii::$app->session->has('language'))
                $where['lang']=\Yii::$app->session->get('language');
            else
                $where['lang']='ru';

			 if($where)
				return Gallery::find()->where($where)->orderby('gallery_order')->all();
			else
				return Gallery::find()->orderby('gallery_order')->all();	
				
		}
}