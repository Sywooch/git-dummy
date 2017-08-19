<?php
namespace app\components\widgets;
 

use yii;
use yii\base\Component;
use yii\base\Widget;

class Language extends Widget
{

    public   $langs=['ru','en'];

    public  $langLabel=['ru'=>['text'=>'Русский','stext'=>'Рус'],
                        'en'=>['text'=>'English','stext'=>'Eng'],];


    public function tabs(){
        return $this->render('tabs',['langs'=>$this->langs,'active'=>yii::$app->language]);
    }

    public function content($view, $data){
        return $this->render('content',['view'=>$view, 'langs'=>$this->langs,'active'=>yii::$app->language,'data'=>$data]);
    }

    public static function getLangs(){
        return array_map(function($lang){
            if(yii::$app->language != $lang) return $lang;
        }, (new self)->langs);
    }

    public static function getArrayLangs(){
        $return = [];
        foreach((new self)->langs as $index){
            $return[$index]=$index;
        }
        return  $return ;
    }

    public static function getModel($model,$lang){
        $id=(int)$model->{$model->tableName().'_id'};

        $model1=$model::find()->where('langid = '.$id.' and lang="'.$lang.'"')->one();
        if($model1 === null)
                return new $model;
        return $model1;

    }

    public function mainList(){
        return $this->render('list_lang',['langs'=>$this->langs,'Label'=>$this->langLabel,'active'=>yii::$app->language]);
    }
}

