<?php

namespace app\modules\shop;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\Session;

class Module extends \yii\base\Module
{
	 
 
	 public function init()
    {
        parent::init();

         
    }


    public function curs()
    {

        $session = new Session;
        $session->open();

        $value = \yii::$app->request->get('vm');

        if($value){

            $curs = \app\modules\shop\models\Curs::find()->where(' name = "'.$value.'" ')->one();

            if($curs === NULL )
                throw new \yii\web\HttpException(404, 'The requested Item could not be found.');
        }
        else{
            if(!$session['id'])
                $curs = \app\modules\shop\models\Curs::find()->where(' id = "4" ')->one();
            else
                $curs = \app\modules\shop\models\Curs::find()->where(' id = "'.$session['id'].'" ')->one();
        }

            $session['id'] = $curs->id;
            $session['curs'] = $curs->curs;
            $session['marker'] = $curs->marker;
    }
	 
	  
}