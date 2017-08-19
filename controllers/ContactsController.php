<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\ContactForm;
use app\modules\staticpage\models\Staticpage;



class ContactsController extends BaseController
{
    

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            
        ];
    }
	
	 
	
	public function actionIndex()
    {
        $model = new ContactForm();
		$staticpage = Staticpage::find()->andWhere([ 'static_page_url' =>'/contacts.html' ] )->one();
	   	 
	   \app\modules\seo\models\Seo::makeHead($staticpage);
		 
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
				'page' => $staticpage,
            ]);
        }
    }
	
	 
	
	
	 

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
