<?php

namespace app\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class MorePrice extends \yii\db\ActiveRecord
{
  
	
    public static function tableName()
    {
        return 'more_price';
    }

	public function attributeLabels()
	{
		return 
		[
			 'catalogid' => Yii::t('admin', 'товар'),
			 'price' => Yii::t('admin', 'Цена'),
			 'mean' => Yii::t('admin', 'Объем'),
			
		];
	}
	
	 
	   public function rules()
    {
        return [
            
			[['catalogid', 'price','mean' ], 'default'],

        ];
    }
	 
  public function getTerms()
    {
        return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['catalog_id' => 'catalogid']);
    }


}