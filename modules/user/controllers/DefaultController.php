<?php

namespace app\modules\user\controllers;

use app\modules\user\models\AccountForm;
use Yii;
use yii\filters\AccessControl;
use yii\imagine\Image;
use yii\web\Controller;

class DefaultController extends Controller
{
    /*public function actions(){
        return [
            'avatar-upload'=>[
                'class'=>UploadAction::className(),
                'fileProcessing'=>function($file){
                    Image::thumbnail($file->path, 215,215)
                        ->save($file->path);
                }
            ]
        ];
    }*/

    public function behaviors()
    {
       
            return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $model = new AccountForm();
        $model->username = $user->username;
        if($model->load($_POST) && $model->validate()){
            $user->username = $model->username;
            $user->setPassword($model->password);
            $user->save();
            Yii::$app->session->setFlash('alert', [
                'options'=>['class'=>'alert-success'],
                'body'=>Yii::t('app', 'Your profile has been successfully saved')
            ]);
            return $this->refresh();
        }
        return $this->render('index', ['model'=>$model]);
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity->profile;
        if($model->load($_POST) && $model->save()){
            Yii::$app->session->setFlash('alert', [
                'options'=>['class'=>'alert-success'],
                'body'=>Yii::t('app', 'Your profile has been successfully saved')
            ]);
            return $this->refresh();
        }
        return $this->render('profile', ['model'=>$model]);
    }
	
	 public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
