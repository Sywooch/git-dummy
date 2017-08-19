<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\modules\catalog\models\Catalog;
use yii\data\ActiveDataProvider;
use app\modules\terms\models\Terms;
use yii\web\Request;


class SearchController extends BaseController
{



    public function actionIndex()
    {
	   $url=\yii::$app->request->get('key','');

        if($url)
	        $model = Catalog::find()->where([ 'like','catalog_title' ,$url ] )->all();

	   return $this->render('index', ['data' => $model]);
    }
	

	
}