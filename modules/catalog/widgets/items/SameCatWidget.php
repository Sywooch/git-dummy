<?php
namespace app\modules\catalog\widgets\items;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\catalog\models\Catalog;


class SameCatWidget extends Widget
{

		public $catid = 0;
        public $limit = 10;
		public $tpl = '';
		public $notin = 0;
		public $urlPrefix = '';
			
	 	public function run()
		{
            $where=[];
            $where['catalog_public']=1;

           if($this->catid)
                $where['catalogcatid']=$this->catid;

           // $where['langid']=0;

			 $data = $this->get( $where );
			 
	        return   $this->render( '@app/views/'.$this->tpl,
					[
					'data' =>$data ,'urlPrefix'=>$this->urlPrefix
					]
					);
	    }
		
		public function get($where)
		{
			 
			return Catalog::find()->andWhere($where)->andWhere(' catalog_count > 0 and  catalog_dateend > "'.date("Y-m-d H:i:s").'"  ')
					->andWhere(' ( catalog_id NOT IN ('.$this->notin.') OR langid NOT IN ('.$this->notin.') )  ')
					->orderby('catalog_date DESC')->limit($this->limit)->all();
		}
}