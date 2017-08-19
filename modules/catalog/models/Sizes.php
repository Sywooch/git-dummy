<?php

namespace app\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Sizes extends \yii\db\ActiveRecord
{
  
	
    public static function tableName()
    {
        return 'one_to_many';
    }


	
	 
	   public function rules()
    {
        return [
            
			[['table_name', 'orderid','itemid' ], 'default'],

        ];
    }
	 
  public function getCatalog()
    {
        return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['catalog_id' => 'orderid']);
    }


}