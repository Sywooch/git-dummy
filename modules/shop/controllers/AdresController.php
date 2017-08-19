<?php



namespace app\modules\shop\controllers;

use app\components\access\RulesControl;
use app\modules\shop\models\ShopAdres;



use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;


class AdresController extends \app\controllers\BaseController//extends Controller
{

    protected function getItems($model=''){

        $searchModel = new ShopAdres();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ['searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model'=>$model];
    }

	public function actionIndex($id=0)
	{
		
		


        $model = $this->findModel($id);


        return $this->render('index', $this->getItems($model));
		 
	 
		
	}
	
	
	 public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно созданы'));
            return $this->redirect(['index']);
        } else {
            return $this->render('index', $this->getItems($model));
        }
    }


    public function actionSet($id)
    {
        if($id && \yii::$app->request->isPost) {
            $model = $this->findModel($id);
            if($model){
                $m=ShopAdres::find()->where('isselect = 1 and userid = '.yii::$app->user->getId())->one();
                if($m){
                    $m->isselect=0;
                    $m->save();
                }

                $model->isselect=1;
                $model->save();
               // print_r($model->getErrors());
            }
        }
        exit;
    }




    public function actionCreate()
    {
        $model = new ShopAdres();

 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash('updated',\Yii::t('admin', 'Данные успешно созданы'));
            return $this->redirect(['index']);
        } else {
            return $this->render('index', $this->getItems($model));
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
        if (($model = ShopAdres::findOne($id)) !== null) {
            return $model;
        } else {
            return new ShopAdres();
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 
	
}