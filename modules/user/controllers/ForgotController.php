<?php

namespace app\modules\user\controllers;
 
use app\modules\user\models\PasswordResetRequestForm;
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
 
class ForgotController extends \app\controllers\BaseController
{

 

      

    public function actionIndex()
    {
        if(\yii::$app->request->isPost){
            $model = new PasswordResetRequestForm();

            if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
                if ($model->sendEmail()) {
//                    Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
                    return \yii::t('app','На вашу почту  было отправлено письмо с дальнейшими действиями');//$this->goHome();
                } else {
                    return \yii::t('app','Извините, email не найден в базе');//$this->goHome();
                    //Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            }

            return \yii::t('app','Извините, email не найден в базе');//$this->goHome();
          /*  return $this->render('forgot', [
                'model' => $model,
            ]);*/
        }
		
    }

  
 

}
