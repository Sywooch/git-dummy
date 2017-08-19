<?php

namespace app\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Character extends \yii\db\ActiveRecord
{
  
	
    public static function tableName()
    {
        return 'character';
    }

	public function attributeLabels()
	{
		return 
		[
			 'itemid' => Yii::t('admin', 'товар'),
			 'price' => Yii::t('admin', 'Цена'),
			 'mean' => Yii::t('admin', 'Объем'),
			
		];
	}
	
	 
	   public function rules()
    {
        return [
            
			[['itemid', 'tablename' ], 'required'],
            [['tablename', 'name','orders' ], 'default'],

        ];
    }
	 



}