<?php



namespace app\modules\catalog\controllers;

use app\components\access\RulesControl;
use app\modules\catalog\models\Catalog;

use trntv\filekit\actions\UploadAction;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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
                        'allow' => RulesControl::callback(['Administrator','Manager']),
						'roles' => ['@'],
                    ]
					 
                ],
            ]
			 
          
        ];
		
    }
 
 	
 
   	
	public function actionIndex()
	{
		
		
	   $searchModel = new Catalog();
	   $searchModel->scenario = 'search';
	   $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	   
	    
        $dataProvider->sort = [
            'defaultOrder'=>['catalog_id'=>SORT_DESC]
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
            'data' =>    Catalog::find()->where([ 'catalog_id' =>$id ] )->one(),//$this->findModel($id),
        ]);
    }
	 
	
	public function actionSetpublic($id, $field)
	{
		
		$model = $this->findModel($id);
		
		$query = new Query;
	 
		if( $model->{$field} ){
            \app\modules\catalog\models\Balance::unHold($id,'end_count_of_product');
            $value = 0 ;
            \yii::$app->db->createCommand("DELETE FROM auct  WHERE  `catalogid` =  $id and tiraj is null and status =0 ")->execute();
        }
		else
            $value = 1;

        $query->createCommand()->update('catalog',[ $field => $value ],[ 'catalog_id' => $id ])->execute();
        $query->createCommand()->update('catalog',[ $field => $value ],[ 'langid' => $id ])->execute();

		echo ( !$model->{$field} ? 
													  \yii\helpers\Html::Tag('span','',['class'=>"glyphicon glyphicon-ok"]) 
													  : 
													  \yii\helpers\Html::Tag('span','',['class'=>"glyphicon glyphicon-remove"])
													    );
														
	}
	public function actionCreate()
    {
        $model = new Catalog();

 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно созданы'));
            echo 'dsfds';
            return $this->redirect(['index']);
        } else {
            print_r($model->getErrors());
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
		\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно удалены'));
        return $this->redirect(['index']);
     }
	
	
	protected function findModel($id)
    {
        if (($model = Catalog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}