<?php
namespace app\modules\reviews\widgets;


#use frontend\models\WidgetMenu;
use yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\AssetBundle;
use app\modules\reviews\models\Reviews;


class ViewWidget extends Widget
{
	    public $tableid = '';
        public $tablename = '';
		public $tpl = '';
	
		
	 	public function run()
		{

            $model=new \app\modules\reviews\models\Reviews;
            if ($model->load(Yii::$app->request->post())  ) {

                $model->reviews_public = 1;
                $model->tablename = $this->tablename;
                $model->tableid = $this->tableid;
                $model->userid = yii::$app->user->getId();

                if ($model->save()) {
                    $model=new \app\modules\reviews\models\Reviews;
                } else {
                    ;
                }
            }



        $data=Reviews::find()->where(' reviews_public = 1 and tableid = '.$this->tableid.' and tablename = "'.$this->tablename.'" ')
                             ->orderby('reviews_date DESC')
                             ->all();
				
			 
	        return   $this->render( '@app/views/'.$this->tpl,
					[
					'data' =>$data ,
                        'model'=>$model
					]
					);
	    }
		

}