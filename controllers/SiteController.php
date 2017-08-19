<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
 
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\components\Sitemap;


class SiteController extends BaseController
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
    public function actionContinue(){
        $items=\app\modules\catalog\models\Catalog::find()->where('lang IS NULL  and catalog_dateend > NOW()')->all();

        $t=0;
        for($i=0;$i<count($items);$i++){
            $item=$items[$i];
            $item->nextDateEnd();
        }
    }
    public function actionSetendtime(){
        $items=\app\modules\catalog\models\Catalog::find()->all();
        $time[0]=0.01;//33;  //1 час
        #$time[1]=1;  // 2 часа
        #$time[2]=2;  //1 час
#        $time[3]=3;  //1 час

        $t=0;
        for($i=0;$i<count($items);$i++){
            $item=$items[$i];
            $where['catalog_date']=date('Y-m-d H:i:s');
            $where['timeend']=$time[rand(0,(count($time)-1))];
            $where['catalog_dateend']=date('Y-m-d H:i:s',mktime()+$where['timeend']*24*3600);

            \yii::$app->db->createCommand()->update('catalog',$where,[ 'catalog_id' => $item->catalog_id ])->execute();
            \yii::$app->db->createCommand()->update('catalog',$where,[ 'langid' => $item->catalog_id ])->execute();

            $t++;
            if($t==3){
                $t=0;
            }
        }
    }
	
	public function actionSitemap()
	{
			Sitemap::index();
	}
	
	public function actionEntry()
    {
        $model = new EntryForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            echo 'good';

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('entry', ['model' => $model]);
        }
    }
	
	 
	
	
	public function actionView($message = 'Hello')
    {
        return $this->render('say', ['message' => $message]);
    }
	
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->redirect('/user/login');
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();

        if(yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            if($model->validate())
            {
                $model->contact(Yii::$app->params['adminEmail']);
            }
            else
            {
                return \yii\helpers\Json::encode([    'error'    =>  $model->getErrors()  ]);
            }
        }
        else{


            if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->refresh();
            } else {
                return $this->render('contact', [
                    'model' => $model,
                ]);
            }

        }

    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionParse(){

        require_once('/home/admin/web/bountymart.com/public_html/components/simple_html_dom/lib/simple_html_dom.php');

        $dom = new \simple_html_dom();
        $dom->load(file_get_contents('https://www.lb.lt/en_index.htm'));
        $tr=$dom->find('.gra2 table tr');

        foreach($tr as $row){
            $Name=$row->find('td',0)->plaintext;
            if($Name=='USD'){
                $eur = $row->find('td',1)->plaintext;
            }
            if($Name=='RUB'){
                $rub = $row->find('td',1)->plaintext;
            }
        }
        $rub=1/$eur*$rub;
        $eur=1/$eur;

        $curs=\app\modules\system\models\Course::find()->where(['alias'=>'Euro'])->one();
        $curs->price=$eur;
        $curs->save();

        $curs=\app\modules\system\models\Course::find()->where(['alias'=>'RUB'])->one();
        $curs->price=$rub;
        $curs->save();

exit;

    }
}
