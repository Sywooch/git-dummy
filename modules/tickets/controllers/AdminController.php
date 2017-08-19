<?php



namespace app\modules\tickets\controllers;

use app\components\access\RulesControl;
use app\modules\tickets\models\Tickets;
use app\modules\tickets\models\Tickets_cat;

use trntv\filekit\actions\UploadAction;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;


class AdminController extends \yii\web\Controller
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


    public function actionMessage()
    {
        $searchModel = new Tickets();
        $dataProvider = $searchModel->message(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['date_modified'=>SORT_DESC]
        ];
        return $this->render('message', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionActivity()
    {
        $searchModel = new Tickets();
        $dataProvider = $searchModel->activity(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['date_modified'=>SORT_DESC]
        ];
        return $this->render('activity', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
   	
	public function actionIndex()
	{
 	   $searchModel = new Tickets_cat();
	    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['date_modified'=>SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

	}
	
	

	
	 public function actionView($id)
    {

        $model = new Tickets();
        $modelc=$this->findModel($id);


        if ($model->load(Yii::$app->request->post())  ) {
            $model->save();
        }

        if ($modelc->load(Yii::$app->request->post())  ) {
            $modelc->save();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelc'=>new Tickets,
        ]);
    }



    public function actionMcreate()
    {
        $model = new Tickets();

        if ($model->load(Yii::$app->request->post())) {
            $model->tcatid=1;
            if($model->save())
                return $this->redirect(['message']);
        } else {
            return $this->render('_form_message', [
                'model' => $model,
            ]);
        }
    }
    public function actionAcreate()
    {
        $model = new Tickets();

        if ($model->load(Yii::$app->request->post())) {
            $model->tcatid=2;
            if($model->save())
                return $this->redirect(['activity']);
        } else {
            return $this->render('_form_activity', [
                'model' => $model,
            ]);
        }
    }


	public function actionCreate()
    {
        $model = new Tickets();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	 

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	 
	 public function actionDelete($id)
     {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
     }
	
	
	protected function findModel($id)
    {
        if (($model = Tickets_cat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}