<?php
namespace app\modules\terms\widgets\tree;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\terms\models\Terms;


class TreeWidget extends Widget
{
	    public $termscatid = '';
		public $termsparent = 0;
		public $offset = '';
		public $tpl = 'tree';
	 
		 
	    public function init()
		{
			Yii::$app->view->registerJsFile( 'assets/terms_tree.js',
					[ 
					'depends' => ['yii\web\YiiAsset',       'yii\bootstrap\BootstrapAsset',]
					]);
	    }
	     
	    public function run()
		{
			 
	        return   $this->render( '@app/modules/terms/widgets/tree/views/'.$this->tpl,[
					'data' => $this->get( ['termscatid' => $this->termscatid, 'terms_parent' => $this->termsparent] ),'offset' => $this->offset 
					]);
	    }
		
		public function get($where)
		{
           			return Terms::find()->andWhere($where)->orderby('terms_order')->all();
		}
}