<?php



namespace app\modules\tickets\controllers;

use app\components\access\RulesControl;
use app\modules\tickets\models\Tickets_cat;
use app\modules\tickets\models\Tickets;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;


class CreateController extends \yii\web\Controller
{
	


 
   	
	public function actionIndex()
	{

        $model = new Tickets();
        $modelc = new Tickets_cat();

        if ($model->load(Yii::$app->request->post()) && $modelc->load(Yii::$app->request->post())) {
            if($id=$modelc->save()){
                $model->tcatid=$id;
                if($model->save())
                    return $this->redirect(['/tickets/list']);
            }
        }
            return $this->render('create', [
                'model' => $model,
                'modelc' => $modelc,
            ]);



    }
	


	
	 
	
}