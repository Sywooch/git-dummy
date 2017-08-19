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
use yii\db\Query;

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
 
 	
 
   	
	public function actionIndex()
	{
		
	  $searchModel = new Reviews();
       
	   $searchModel->scenario = 'search';
	    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	   
	    
        $dataProvider->sort = [
            'defaultOrder'=>['reviews_id'=>SORT_DESC]
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
            return $this->redirect(['index']);
        } else {
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
        $model = new Reviews();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			 
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSetpublic($id, $field)
    {

        $model = $this->findModel($id);

        $query = new Query;

        if( $model->{$field} )
            $query->createCommand()->update('reviews',[ $field => 0 ],[ 'reviews_id' => $id ])->execute();
        else
            $query->createCommand()->update('reviews',[ $field => 1 ],[ 'reviews_id' => $id ])->execute();

        echo ( !$model->{$field} ?
            \yii\helpers\Html::Tag('span','',['class'=>"glyphicon glyphicon-ok"])
            :
            \yii\helpers\Html::Tag('span','',['class'=>"glyphicon glyphicon-remove"])
        );

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
        if (($model = Reviews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}