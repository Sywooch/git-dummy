<?php

namespace app\models;

use yii\base\Model;

class OrderForm extends Model
{
    public $place;
    public $adres;


    public function rules()
    {
        return [
            [['place', 'adres'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'place' => \Yii::t('app', 'Месторасположения'),
            'adres' => \Yii::t('app', 'Адрес'),
        ];
    }
}