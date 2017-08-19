<?php

namespace app\models;

use yii\db\ActiveRecord;

class Webtopay extends ActiveRecord
{

    public static function tableName()
    {
        return 'webtopay';
    }

    public function rules()
    {
        return [
            [ ['id','shopid','userid','approve'], 'default'],
        ];
    }


    public function getUser(){
        return $this->hasOne(User::className(), ['id'=>'userid']);
    }
}