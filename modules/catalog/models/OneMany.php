<?php

namespace app\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class OneMany extends \yii\db\ActiveRecord
{
  
	
    public static function tableName()
    {
        return 'one_to_many';
    }

	public function attributeLabels()
	{
		return 
		[
			 'table_name' => Yii::t('admin', 'товар'),
			 'orderid' => Yii::t('admin', 'Цена'),
			 'itemid' => Yii::t('admin', 'Объем'),
			
		];
	}
	
	 
	   public function rules()
    {
        return [
            
			[['table_name', 'orderid','itemid' ], 'default'],

        ];
    }
	 
  public function getTerms()
    {
        return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'itemid']);
    }


}