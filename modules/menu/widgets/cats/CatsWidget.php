<?php
namespace app\modules\menu\widgets\cats;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\terms\models\Terms;


class CatsWidget extends Widget
{

		public $tpl = '';
        public $parent = 0;
	    public $submenu = 1;
		
	 	public function run()
		{
			 $data = $this->get( [ 'termscatid'=>1, 'langid'=>0, 'terms_parent'=>$this->parent ] );
			 
	        return   $this->render( '@app/views/'.$this->tpl,
					[
					'data' =>$data,
                        'submenu' => $this->submenu
					]
					);
	    }
		
		public function get($where)
		{
			 
			return Terms::find()->where($where)->orderby('terms_order')->all();
		}
}