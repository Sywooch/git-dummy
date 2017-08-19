<?php
namespace app\modules\terms\widgets\cats;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\terms\models\Terms;


class CatsWidget extends Widget
{
	    public $termid = '';
		public $parentid = 0;
		public $tpl = '';
		public $urlPrefix = '';
        public $submenu = '';
			
	 	public function run()
		{



			 $data = $this->get( [ 'termscatid' => $this->termid ,'terms_parent' => $this->parentid ] );
			 
	        return   $this->render( '@app/views/'.$this->tpl,
					[
					'data' =>$data ,
					'urlPrefix'=>$this->urlPrefix,
					'terms_public'=>1,
					'submenu'=>$this->submenu
					]
					);
	    }
		
		public function get($where)
		{

			return Terms::find()->andWhere($where)->orderby('terms_order')->all();
		}
}