<?php

    namespace app\controllers;

    use yii;
    use yii\web\Controller;
    use yii\data\Pagination;
    use app\modules\catalog\models\Balance;
    use yii\data\ActiveDataProvider;
    use app\modules\terms\models\Terms;
    use app\modules\tickets\models\Tickets;

    class MessageController extends BaseController
    {

        public function actionTypethread(){
            if(!yii::$app->user->getId())
                throw new \yii\web\HttpException(404, 'The requested Item could not be found.');

            if(\yii::$app->request->isPost && $key = \yii::$app->request->post('key')){

                $query = Tickets::find();
                $query->andWhere(' tcatid = 1 and userid = '.yii::$app->user->getId().' ');
                $query->andWhere(' message LIKE "%'.$key.'%"');


                if( yii::$app->request->post('datefrom') && yii::$app->request->post('dateto') ){
                    $datefrom=date("Y-m-d H:i:s",strtotime( yii::$app->request->post('datefrom') ));
                    $dateto=date("Y-m-d H:i:s",strtotime( yii::$app->request->post('dateto') ) + 3600*24);
                    $query->andWhere(' date_modified <= "'.$dateto.'" and date_modified >= "'.$datefrom.'"');
                }elseif( yii::$app->request->get('dateto') ) {
                    $dateto = date("Y-m-d H:i:s", strtotime(yii::$app->request->post('dateto')) + 3600 * 24);
                    $query->andWhere(' date_modified <= "' . $dateto . '"');
                }


                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>200]);

                $_GET['key'] = $key;


                $query->orderBy(' date_modified DESC, statusid DESC');

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

            $searchModel = Tickets::find()->where(' tcatid = 1 and userid = '.yii::$app->user->getId().' ');



            $url = Yii::$app->request->queryParams;
            $url['order']=(yii::$app->request->get('order')=='desc')?'asc':'desc';


            if( yii::$app->request->get('order') ){
                $searchModel->orderBy(' date_modified '.yii::$app->request->get('order'));
            }else{
                $searchModel->orderBy(' date_modified DESC');
            }


            if( $key = yii::$app->request->get('key') ) {
                $searchModel->andWhere(' message LIKE "%' . $key . '%"');
            }


            if( yii::$app->request->get('datefrom') && yii::$app->request->get('dateto') ){
                $datefrom=date("Y-m-d H:i:s",strtotime( yii::$app->request->get('datefrom') ));
                $dateto=date("Y-m-d H:i:s",strtotime( yii::$app->request->get('dateto') ) + 3600*24);
                $searchModel->andWhere(' date_modified <= "'.$dateto.'" and date_modified >= "'.$datefrom.'"');
            }elseif( yii::$app->request->get('dateto') ){
                $dateto=date("Y-m-d H:i:s",strtotime( yii::$app->request->get('dateto') ) + 3600*24);
                $searchModel->andWhere(' date_modified <= "'.$dateto.'"');
            }

            $countQuery = clone $searchModel;
            $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>15]);

            $models = $searchModel->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            return $this->render('index', [
                'models' => $models,
                'pages' => $pages,
                'url'=>$url,
            ]);
        }




    }