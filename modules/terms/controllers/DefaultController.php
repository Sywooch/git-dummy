<?php



namespace app\modules\terms\controllers;

use app\components\access\RulesControl;
use app\modules\terms\models\Terms;
use app\modules\terms\models\Terms_cat;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class DefaultController extends \yii\web\Controller
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
            ],
        ];
		
    }
		
	public function actionIndex()
	{
		
		$searchModel = new Terms();
       
	    $searchModel->scenario = 'search';
	    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	   
	    
        $dataProvider->sort = [
            'defaultOrder'=>['seo_id'=>SORT_DESC]
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
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно изменены'));
			\Yii::$app->session->setFlash('termscatid',$model->termscatid);
            return $this->redirect( \Yii::$app->request->getReferrer() );
        } else {
            if(Yii::$app->request->isAjax)
			return $this->renderAjax('update', [
                'model' => $model,
            ]);
			else
			return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	 public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	 
	
	public function actionCreate()
    {
        $model = new Terms();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно созданы'));
			\Yii::$app->session->setFlash('termscatid',$model->termscatid);
			
			 $url = Url::to(['create']);
		 
		  
			if( \Yii::$app->request->getReferrer() && !strstr(\Yii::$app->request->getReferrer(),$url) )
	            return $this->redirect( \Yii::$app->request->getReferrer() );
			else
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
	 
	  public function actionOrder($id,$position)
     {
        $model=$this->findModel($id);
		$model->terms_order = $position;
		$model->save();
        die('ok');
     }
	 
	  public function actionAttrpublic($id)
     {
        $model=$this->findModel($id);
		if( $model->terms_public == 1 )
			$model->terms_public = 0;
		else
			$model->terms_public = 1;		
		
		$model->save();
        die('ok');
     }
	 
	 
	 public function actionDelete($id)
     {

		 
        $model=$this->findModel($id);
		\Yii::$app->session->setFlash('termscatid',$model->termscatid);
		$model->delete();
        return $this->redirect( \Yii::$app->request->getReferrer() );
     }
	
	
	protected function findModel($id)
    {
		 
		
        if (($model = Terms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}