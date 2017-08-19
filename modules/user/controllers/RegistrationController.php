<?php

namespace app\modules\user\controllers;
 
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegistrationForm;
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
 
class RegistrationController extends \app\controllers\BaseController
{

 



    public function actionIndex()
    {
        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->role=1;
            if ($user = $model->signup()) {


            }
        }


        //какойто костыл
        if ($model->load(Yii::$app->request->post())) {
            $user = User::findByUsername($model->username);
            if($user  && $user->validatePassword($model->password)){
                Yii::$app->user->login($user,0);
                \Yii::$app->session->setFlash('registration',1);


                return $this->redirect('/user/profile');
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function login($email){
        $user = User::find()->where(['or', ['username'=>$email], ['email'=>$email]])->one();
        if ($user) {
            if(\Yii::$app->user->login($user,0)){
                return true;
            }
        } else {
            return false;
        }
    }

    public function actionValidate(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new RegistrationForm();
        $model->load(Yii::$app->request->post());
        $model->validate();
        return $model->getErrors();
    }


    public function actionApproveemail($code){
        if($code){
            $user=\app\models\User::find()->where('auth_key = "'.$code.'" ')->one();
            if($user){
                $user->isemail=1;
                if($user->save()){
                    \Yii::$app->session->setFlash('email',\Yii::t('app', 'Ваш Email подтвержден, вы можете делать ставки на сайте'));
                    return $this->redirect('/user/profile');
                }
            }
        }
    }
 

}
