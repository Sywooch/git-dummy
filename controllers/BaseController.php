<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\modules\catalog\models\Catalog;
use yii\data\ActiveDataProvider;
use app\modules\terms\models\Terms;
use yii\helpers\ArrayHelper;

class BaseController extends Controller
{
    public $breadcrumbs=[];
    public $config='';
    public $path='/var/www/html/config';

    public function beforeAction($action)
    {

        $this->config=array(
            'sign_password' => '274418add9b6d8663419e406bb41d7fd',        // your password
            'projectid' => 89078,                                          // your project id

            'test' => 0,            // disable in production
            'accepturl' => 'http://bountymart.com/pay/accept',
            'cancelurl' => 'http://bountymart.com/pay/cancel',
            'callbackurl' => 'http://bountymart.com/pay/callback',
        );


       /* echo 'first<br>';
        echo 'session - '.\Yii::$app->session->get('language').'<br>';
        echo 'get - '.\Yii::$app->request->get('lang').'<br>';
        echo 'cookie - '.$_COOKIE['langss'];*/

        if (!isset($_COOKIE['langss'])) {
          $_COOKIE['langss'] = null;
        }

        if(\yii::$app->request->get('reset')){
            unset($_SESSION['language']);
            unset($_SESSION['currency']);
            unset($_COOKIE['langss']);
            \Yii::$app->session->set('language','');
            \Yii::$app->session->set('currency', '');
        }


        $json=file_get_contents('http://api.sypexgeo.net/json/'.$_SERVER['REMOTE_ADDR']);
        $json=json_decode($json,true);

        if(isset($json['country']['iso']))
            $lang=strtolower($json['country']['iso']);
        else
            $lang = \app\components\GeoIp::getCountryID();

        if(!$lang){
            if(!\Yii::$app->session->get('currency'))
                \Yii::$app->session->set('currency', 'USD');

            if(!\Yii::$app->session->get('language'))
                 \Yii::$app->session->set('language', 'en');
        }

       /* $blocked=['uk','at','be','bg','gb','hu','de','gr','dk','ie','es','it','cy','lv','lt','lu','mt','nl','pl','sk','si','pt','ro','fi','fr','hr','se','ee','cz'];
        if(in_array ($lang,$blocked)){
            echo 'Site is blocked!';
            exit;
        }*/
        $ru=['ru'=>1,'kz'=>1];
        $usd=['by'=>1,'ua'=>1];

        if($lang && (!\yii::$app->request->get('lang') &&  \Yii::$app->session->get('language')=='' && !$_COOKIE['langss'])  )
        {
            //\Yii::$app->session->set('currency', 'RUB');
            if (isset($usd[$lang]) || isset($ru[$lang]) ) {
                \Yii::$app->session->set('language', 'ru');

                if (isset($usd[$lang]) && !\yii::$app->session->get('currency')) {
                    \Yii::$app->session->set('currency', 'USD');
                } elseif (isset($ru[$lang]) && !\yii::$app->session->get('currency')) {
                    \Yii::$app->session->set('currency', 'RUB');
                }


            }else{
                \Yii::$app->session->set('language','en');
            }
        }elseif( \yii::$app->request->get('lang') || $_COOKIE['langss'] ){
            if( !\Yii::$app->session->has('language') && !\yii::$app->request->get('lang') )
                \Yii::$app->session->set('language',$_COOKIE['langss']);
            elseif(\yii::$app->request->get('lang'))
                \Yii::$app->session->set('language',\yii::$app->request->get('lang'));
        }
        \yii::$app->language = \Yii::$app->session->get('language');



        if (!\yii::$app->request->get('currency') && !\Yii::$app->session->get('currency')) {
            if(!\Yii::$app->session->get('currency'))
                \Yii::$app->session->set('currency', 'USD');


        }elseif(\yii::$app->request->get('currency')){
            if($course=\app\modules\system\models\Course::get(\yii::$app->request->get('currency')))
                \Yii::$app->session->set('currency', \yii::$app->request->get('currency'));
            else
                \Yii::$app->session->set('currency', 'RUB');
        }

        /* echo '<br>end<br>';
        echo 'session - '.\Yii::$app->session->get('language').'<br>';
        echo 'get - '.\Yii::$app->request->get('lang').'<br>';
        echo 'cookie - '.$_COOKIE['langss'].'<br>';
        echo 'language - '. \yii::$app->language .'<br>';
        echo 'currency - '. \yii::$app->request->get('currency').' session-'. \yii::$app->session->get('currency') ;*/

;

        if(\yii::$app->user->getID()){
            if(\yii::$app->user->identity->lang != \yii::$app->language){
                \yii::$app->user->identity->lang = \yii::$app->language;
                \yii::$app->user->identity->save();
            }
        }

        if(\yii::$app->language=='en') {
            \yii::$app->params = \yii\helpers\ArrayHelper::merge(\yii::$app->params, require_once($this->path . '/params_change_' . \yii::$app->language . '.php'));
        }

        if (parent::beforeAction($action)) {
            if ($this->enableCsrfValidation && \Yii::$app->getErrorHandler()->exception === null && !\Yii::$app->getRequest()->validateCsrfToken()) {
                throw new BadRequestHttpException( 'Unable to verify your data submission.');
            }


            return true;
        }
        return false;
    }


}