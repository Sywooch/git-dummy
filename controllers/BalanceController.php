<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\modules\catalog\models\Balance;
use yii\data\ActiveDataProvider;
use app\modules\terms\models\Terms;

class BalanceController extends BaseController
{


    public function actionTypethread(){

        if(!yii::$app->user->getId())
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

        if(\yii::$app->request->isPost && $key = \yii::$app->request->post('key')){

            $query = Balance::find();
            $query->andWhere(' userid = '.yii::$app->user->getId().' ');
            $query->andWhere(' comment LIKE "%'.$key.'%"');
            $query->andWhere(' hide = 0 ');


            if( yii::$app->request->post('datefrom') && yii::$app->request->post('dateto') ){
                $datefrom=date("Y-m-d H:i:s",strtotime( yii::$app->request->post('datefrom') ));
                $dateto=date("Y-m-d H:i:s",strtotime( yii::$app->request->post('dateto') ) + 3600*24);
                $query->andWhere(' date <= "'.$dateto.'" and date >= "'.$datefrom.'"');
            }elseif( yii::$app->request->get('dateto') ) {
                $dateto = date("Y-m-d H:i:s", strtotime(yii::$app->request->post('dateto')) + 3600 * 24);
                $query->andWhere(' date <= "' . $dateto . '"');
            }


            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>200]);

            $_GET['key'] = $key;

            $query->orderBy(' id DESC');

            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            echo $this->renderPartial('_ajax_body',  [ 'models'=>$models,'pages'=>$pages   ]);
            exit;
        }
    }


    public function actionIndex()
    {

        if(!yii::$app->user->getId())
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

        $searchModel = Balance::find()->where('userid = '.yii::$app->user->getId());



        if( yii::$app->request->get('datefrom') && yii::$app->request->get('dateto') ){
            $datefrom=date("Y-m-d H:i:s",strtotime( yii::$app->request->get('datefrom') ));
            $dateto=date("Y-m-d H:i:s",strtotime( yii::$app->request->get('dateto') ) + 3600*24);
            $searchModel->andWhere(' `date` <= "'.$dateto.'" and `date` >= "'.$datefrom.'"');
        }elseif( yii::$app->request->get('dateto') ){
            $dateto=date("Y-m-d H:i:s",strtotime( yii::$app->request->get('dateto') ) + 3600*24);
            $searchModel->andWhere(' `date` <= "'.$dateto.'"');
        }
        if($key = \yii::$app->request->get('key'))
         $searchModel->andWhere(' comment LIKE "%'.$key.'%"');



        if( yii::$app->request->get('order') ){
            $searchModel->orderBy(' date '.yii::$app->request->get('order'));
        }else{
            $searchModel->orderBy(' id DESC');
        }



        $countQuery = clone $searchModel;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>15]);
        $models = $searchModel->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        $url = Yii::$app->request->queryParams;
       $url['order']=(yii::$app->request->get('order')=='desc')?'asc':'desc';



        return $this->render('index', [
          /*  'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,*/
            'models' => $models,
            'pages' => $pages,
            'url'=>$url,
        ]);
    }

public function actionUpdate(){
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if(yii::$app->request->isPost){
        if($balance = \app\models\User::setBalance(yii::$app->request->post('amount')))
            $items = ['status'=>'success','money'=>$balance];
        else
            $items = ['status'=>'error'];

            return $items;
    }else{
        return ['status'=>'error'];
    }
}


	public function actionOut(){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(yii::$app->request->isPost){
            if(!$error = \app\modules\catalog\models\Balance_out::addOut())
                $items = ['status'=>'success'];
            else
                $items = ['status'=>'error','error'=>$error];

            return $items;
        }else{
            return ['status'=>'error','error'=>'Сервис недоступен попробуйте позже'];
        }

    }
	

	
	
}