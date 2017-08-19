<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\modules\news\models\News;
use app\modules\terms\models\Terms;

class PnewsController extends BaseController
{
    public function actionView($url)
    {
	   $url='/news/'.$url.'.html';	
       $model = News::find()->where([ 'news_url' =>$url ] )->one();
	  
	   \app\modules\seo\models\Seo::makeHead($model);
	   
	   return $this->render('view', ['data' => $model]);
    }
	
	 public function actionList($url='')
    {
		$terms = '';
		
		if($url){
			$terms = Terms::getId($url, 6);
			$query = News::find()->Where(['newscatid'=>$terms['terms_id']])->orderBy(['news_date'=>SORT_DESC]);
			}
		else
			$query = News::find()->orderBy(['news_date'=>SORT_DESC]);
		
		 \app\modules\seo\models\Seo::makeHead($terms);
		 
		 $dataProvider = new ActiveDataProvider(
            [
                'query'=>$query,
                'pagination' => [
                    'pageSize' => 2,
                ],
				
            ]
        );
   
		
	   return $this->render('list',  ['dataProvider'=>$dataProvider]);
    }


    public function actionFaq()
    {

        $terms = Terms::findOne(168);
        $menu = Terms::find()->andWhere(['terms_public'=>1,'terms_parent'=>168])->all();
        if(!\yii::$app->request->get('url'))
            $id=$menu[0]->terms_id;
        else{
            $id = Terms::find()->AndWhere(['terms_url'=>\yii::$app->request->get('url'),'terms_parent'=>168])->one();
            $id=$id->terms_id;
        }

        $query = News::find()->andWhere(['newscatid'=>$id])->orderBy(['news_date'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider(
            [
                'query'=>$query,
                'pagination' => [
                    'pageSize' => 200,
                ],

            ]
        );


        return $this->render('faq_list',  ['id'=>$id,'menu'=>$menu,'dataProvider'=>$dataProvider]);
    }
}