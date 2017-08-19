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
 
class LogoutController extends Controller
{

 



    public function actionIndex()
    {

        Yii::$app->user->logout();
        return $this->redirect('/');
    }

  
 

}
