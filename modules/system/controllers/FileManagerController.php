<?php

 
namespace app\modules\system\controllers;

use app\components\access\RulesControl;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

class FileManagerController extends \yii\web\Controller
{
	 public $layout='@app/views/layouts/admin.php';
	 
	 public function behaviors()
    {
        return [
            'access' => [
                'class' =>  AccessControl::className(),
                'rules' => [
                    [
                        'allow' => RulesControl::callback('Administrator'),
						'roles' => ['@'],
                    ]
					 
                ],
            ],
        ];
		
    }
	
    public function actions(){
        return [
            'upload-imperavi'=>[
                'class'=>'trntv\filekit\actions\UploadAction',
                'fileparam'=>'file',
                'responseUrlParam'=>'filelink',
                'disableCsrf'=>true
            ]
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
}
