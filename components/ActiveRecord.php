<?php
    namespace app\components;

    use Yii;
    use app\components\LanguageTrate;

class ActiveRecord extends  \yii\db\ActiveRecord{

    //use LanguageTrate;


    public static function find()
    {


        if( \Yii::$app->session->has('language') && yii::$app->user->getId() != 1 && Yii::$app->session->get('language')!='ru'){
            return parent::find()->where('lang = "'.Yii::$app->session->get('language').'" ');
        }
        elseif( (yii::$app->user->getId() == 1) )
            return parent::find()->where(' lang is  NULL ');
        else
            return parent::find()->where(' lang is  NULL ');
            //return parent::find();
    }







}