<?php
namespace app\modules\menu\widgets\view;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\menu\models\Menu;


class ViewWidget extends Widget
{
	    public $code = '';
		public $tpl = '';
        public $parent = 0;
        public $submenu = 1;
	
		
	 	public function run()
		{

            if($this->parent)
			 $data = $this->get( [  'menu_parentid'=>$this->parent,  'menu_public' => 1] );
            else
                $data = $this->get( [ 'alias' => $this->code ,  'menu_parentid'=>$this->parent] );

	        return   $this->render( '@app/views/'.$this->tpl,
					[
					'data' =>$data ,
                    'submenu' => $this->submenu
					]
					);
	    }
		
		public function get($where)
		{
			 
			return Menu::find()->andWhere($where)->orderby('menu_order')->all();
		}
}