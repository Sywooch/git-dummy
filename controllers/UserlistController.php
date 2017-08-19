<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\modules\catalog\models\Userlist;
use yii\data\ActiveDataProvider;
use app\modules\terms\models\Terms;

class UserlistController extends BaseController
{


    public function actionIndex()
    {


        $searchModel = new Userlist();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $model = new Userlist();
        if ($model->load(Yii::$app->request->post())) {
            $model->userid=yii::$app->user->getId();
            if ($model->save()) {
                return $this->redirect(['index']);
            }else{

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionGood($id)
    {
        $this->changeStatus($id,0);
    }

    public function actionBad($id)
    {
        $this->changeStatus($id,1);
    }

    public function changeStatus($id, $num){
        $model=new Userlist;
        $model->userid = yii::$app->user->getId();
        $model->workerid = $id;
        $model->status = $num;
        $model->save();
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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