<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\modules\staticpage\models\Staticpage;

class PageController extends BaseController
{
    public function actionView($url)
    {
        $index=$url;
	    $url='/'.$url.'.html';

       $model = Staticpage::find()->andWhere([ 'static_page_url' =>$url ] )->one();

        if(!$model)
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

       $this->breadcrumbs[]= ['label' => $model->static_page_title];


	   \app\modules\seo\models\Seo::makeHead($model);
	   
	   return $this->render('view', ['index'=>$index, 'data' => $model,'breadcrumbs'=>$this->breadcrumbs]);
    }
}