<?php
namespace app\modules\menu\widgets\tree;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\menu\models\Menu;


class TreeWidget extends Widget
{
	    public $termin = '';
		public $termsparent = 0;
		public $offset = '';
	 
		 
	    public function init()
		{
			Yii::$app->view->registerJsFile( 'assets/tree.js',
					[ 
					'depends' => ['yii\web\YiiAsset',       'yii\bootstrap\BootstrapAsset',]
					]);
	    }
	     
	    public function run()
		{
			 
	        return   $this->render( '@app/modules/menu/widgets/tree/views/tree',[
					'data' => $this->get( ['alias' => $this->termin, 'menu_parentid' => $this->termsparent] ),'offset' => $this->offset 
					]);
	    }
		
		public function get($where)
		{
			 
			return Menu::find()->andWhere($where)->orderby('menu_order')->all();
		}
}