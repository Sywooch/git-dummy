<?php



namespace app\modules\reviews\controllers;

use app\components\access\RulesControl;
use app\modules\reviews\models\Reviews;

use trntv\filekit\actions\UploadAction;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;


class AddController extends \yii\web\Controller
{


	
	public function actionIndex()
    {
        $model = new Reviews();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			 
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	 


	
	protected function findModel($id)
    {
        if (($model = Reviews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}