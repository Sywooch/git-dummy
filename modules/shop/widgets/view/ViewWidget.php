<?php
namespace app\modules\news\widgets\view;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\news\models\News;


class ViewWidget extends Widget
{
	    public $newscatid = '';
   	    public $limit = 2;
		public $tpl = '';
		
	 	public function run()
		{
			 $data = $this->get( [ 'newscatid' => $this->newscatid ] );
			 
	        return   $this->render( '@app/views/'.$this->tpl,
					[
					'data' =>$data 
					]
					);
	    }
		
		public function get($where)
		{
			 
			return News::find()->where($where)->orderby('news_date desc')->limit($this->limit)->all();
		}
}