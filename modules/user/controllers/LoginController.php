<?php

namespace app\modules\user\controllers;
 
use app\modules\user\models\LoginForm;
use app\models\User;
use yii\web\Controller;
 
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
 
class LoginController extends \app\controllers\BaseController
{

      

    public function actionIndex()
    {
        $post = yii::$app->request->post();


if(yii::$app->user->getId())
    $this->redirect('/user/profile');

  //      echo Yii::$app->request->cookies['test'];
//        echo Yii::$app->request->cookies->getValue('test');

        $model = new LoginForm();
        if (Yii::$app->request->isAjax) {
            $model->load($_POST);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
		
		 
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			   if( User::ROLE_ADMINISTRATOR == Yii::$app->user->identity->role   )
			   		 
					$this->redirect(['/catalog/info/index'/*Yii::$app->params['redirectAuth']*/]);
			   else
                   $this->redirect('/');
			   		#return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        } 
		
    }

  
 

}
