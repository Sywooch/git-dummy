<?php
namespace app\modules\catalog\widgets\items;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\catalog\models\Catalog;


class ProductsWidget extends Widget
{
	    public $field = '';
		public $catid = 0;
        public $limit = 10;
        public $where='';
		public $tpl = '';
		public $urlPrefix = '';
        public $order = 'catalog_date';

			
	 	public function run()
		{
            $where = [];

			if(\yii::$app->user->getId() && \yii::$app->user->identity->role != 1) {
				if($this->field && $this->field!='catalog_public')
					$where[$this->field]=1;
			}
			else{
				$where['catalog_public']=1;
				if($this->field)
					$where[$this->field]=1;
			}

            if($this->field)
                $where[$this->field]=1;

            if($this->catid)
                $where['catalogcatid']=$this->catid;

			 $data = $this->get( $where );
			 
	        return   $this->render( '@app/views/widgets/'.$this->tpl,
					[
					'data' =>$data ,'urlPrefix'=>$this->urlPrefix
					]
					);
	    }
		
		public function get($where)
		{

			 if($this->where)$this->where=$this->where.' and ';


			return Catalog::find()->andWhere($where)
					->andWhere($this->where.' catalog_count > 0 and  catalog_dateend > "'.date("Y-m-d H:i:s",mktime()).'"  ')
					->orderby($this->order)->limit($this->limit)->all();
		}
}