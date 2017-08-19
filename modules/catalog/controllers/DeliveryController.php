<?php



namespace app\modules\catalog\controllers;

use app\components\access\RulesControl;
use app\models\Todeliver;

use trntv\filekit\actions\UploadAction;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\db\Query;

class DeliveryController extends \yii\web\Controller
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
		
		
	   $searchModel = new Todeliver();
	  // $searchModel->scenario = 'all';
	   $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	   
	    

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		 
	 
		
	}

    public function actionStatus($id)
    {


        $model = $this->findModel($id);
        $model->statusid = (int)yii::$app->request->get('status',0);
        $model->save();
exit;


    }
    protected function findModel($id)
    {
        if (($model = Todeliver::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



	 
	
}