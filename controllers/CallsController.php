<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\modules\catalog\models\Catalog;
use yii\data\ActiveDataProvider;
use app\modules\terms\models\Terms;

class CallsController extends BaseController
{


    public function actionIndex()
    {


        $searchModel = new Catalog();
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionMy()
    {
        $searchModel = new Catalog();
        $searchModel->scenario = 'search';

        Yii::$app->request->queryParams['workerid'] = yii::$app->user->getId();
        $_GET['workerid'] = yii::$app->user->getId();

        $dataProvider = $searchModel->search_work(Yii::$app->request->queryParams);
        return $this->render('index-my', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChangestatus($id,$status)
    {
        $model=$this->findModel($id);
        $model->statusid = $status;
        if( Yii::$app->request->post('msg') )
        $model->comment =  '<pre>'.$model->worker->username.' - '.date('d-m-Y H:i').'<br>'.Yii::$app->request->post('msg').'</pre>' .$model->comment;


        if($model->statusid == Catalog::STATUS_DONECONFRIME){
             $allPrice=$model->allPrice();

            \app\modules\catalog\models\Balance::resetHold($model->userid,$model->catalog_id,'списание за прозвон');
            \app\models\User::setBalance('+'.$allPrice,$model->workerid,$model->catalog_id,'начисление за прозвон');
        }


        if(!$model->save())
            print_r($model->getErrors());

    }


    public function actionView($id)
    {
	   $model = Catalog::find()->where([ 'catalog_id' =>$id ] )->one();
	   return $this->render('view', ['data' => $model ]);
    }

    public function actionGetcomments($id){
        $model = Catalog::find()->where([ 'catalog_id' =>$id ] )->one();
        if($model!==null){
            return $model->comment;
        }
        exit;
    }

    public function actionCreate()
    {
        if(!\app\models\User::checkBalance(10))
        {
            \Yii::$app->session->setFlash('money',\Yii::t('admin', 'У вас не хватает средств для данной операции'));
            return $this->redirect(['index']);
        }

        $model = new Catalog();
        if ($model->load(Yii::$app->request->post())) {
            $model->userid=yii::$app->user->getId();

            if(!\app\models\User::checkBalance($allPrice=$model->allPrice()))
            {
                \Yii::$app->session->setFlash('money',\Yii::t('admin', 'У вас не хватает средств для данной операции'));
                return $this->redirect(['index']);
            }

            if ($model->save()) {
                \app\models\User::setBalance('-'.$allPrice,$model->userid,$model->catalog_id,'списание/сезервирование за прозвон','holdstat');
                return $this->redirect(['index']);
            }else{

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {


        $user = $this->findModel($id);
        if(isset($_POST['Catalog']['comment'])){
            $_POST['Catalog']['comment'] =  '<pre>'.$user->user->username.' - '.date('d-m-Y H:i').'<br>'. $_POST['Catalog']['comment'].'</pre>' .$user->comment;
            $_POST['Catalog']['statusid'] = Catalog::STATUS_ACSEPT;
        }

        if ($user->load( $_POST  ) ) {
            if($user->save()){


                return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $user,
            ]);
        }

        return $this->render('update', [
            'model' => $user,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        \app\modules\catalog\models\Balance::returnHold( $this->findModel($id) )->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Catalog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	

	
	
}