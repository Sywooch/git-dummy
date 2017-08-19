<?php

namespace app\modules\user\controllers;
 
use app\modules\user\models\ResetPasswordForm;

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
 
class ResetpasswordController extends Controller
{

 




    public function actionIndex($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->redirect('/user/login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


 

}
