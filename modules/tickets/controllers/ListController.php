<?php



namespace app\modules\tickets\controllers;

use app\components\access\RulesControl;
use app\modules\tickets\models\Tickets_cat;
use app\modules\tickets\models\Tickets;

use trntv\filekit\actions\UploadAction;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;


class ListController extends \yii\web\Controller
{
	


 
   	
	public function actionIndex()
	{
 	   $searchModel = new Tickets_cat();
	    $dataProvider = $searchModel->searchFront(Yii::$app->request->queryParams);
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
            $modelc->statusid=118;
            $modelc->save();

        }

        return $this->render('view', [
            'model' => $modelc,
            'modelc'=>$model,
        ]);
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