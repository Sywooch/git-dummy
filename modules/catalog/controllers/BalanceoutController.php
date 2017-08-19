<?php



namespace app\modules\catalog\controllers;

use app\components\access\RulesControl;
use app\modules\catalog\models\Balance_out;

use trntv\filekit\actions\UploadAction;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\Query;

class BalanceoutController extends \yii\web\Controller
{
	
 public $layout='@app/views/layouts/admin.php';
	 
 public function behaviors()
    {
        return [
            'access' => [
                'class' =>  AccessControl::className(),
                'rules' => [
                    [
                        'allow' => RulesControl::callback('Administrator'),
						'roles' => ['@'],
                    ]
					 
                ],
            ]
			 
          
        ];
		
    }
 
 	
 
   	
	public function actionIndex()
	{
		
		
	   $searchModel = new Balance_out();
	  // $searchModel->scenario = 'all';
	   $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	   
	    
        $dataProvider->sort = [
            'defaultOrder'=>['status'=>SORT_ASC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		 
	 
		
	}
	
	
	 public function actionUpdate($id)
    {

        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно созданы'));
            if($model->status == 2 && $model->historyid){

                \app\modules\catalog\models\Balance::returnHoldById($model->historyid,$model->comment);

            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	

	


	
	protected function findModel($id)
    {
        if (($model = Balance_out::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}