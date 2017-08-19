<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\modules\gallery\models\Gallery;
use yii\data\ActiveDataProvider;
use app\modules\terms\models\Terms;

class PgalleryController extends BaseController
{
    public function actionView($url)
    {
	   $url=/*Gallery::urlPrefix().*/$url/*.'.html'*/;
       $model = Gallery::find()->where([ 'gallery_url' =>$url ] )->one();
	   //\app\modules\seo\models\Seo::makeHead($model);
	   return $this->render('view', ['data' => $model]);
    }
	
 	public function actionIndex()
	{
		return $this->render('index');
	}
		
	 public function actionList($url='')
    {

		if($url){
			$terms = Terms::getId($url, 8);
			 
			$query = Gallery::find()->Where(['gallerycatid'=>$terms['terms_id']])->orderBy(['gallery_date'=>SORT_DESC]);
			}
		else
			$query = Gallery::find()->orderBy(['gallery_date'=>SORT_DESC]);	
		 
		 
		// \app\modules\seo\models\Seo::makeHead($terms);
		
		 
		 $dataProvider = new ActiveDataProvider(
            [
                'query'=>$query,
				'pagination' => [
				        'pageSize' => 100, 
					
							    ],
            ]
        );
   
		
	   return $this->render('list',  ['dataProvider'=>$dataProvider]);
    }
	
	
}