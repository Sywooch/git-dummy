<?php

namespace app\modules\shop\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class ShopAdres extends \yii\db\ActiveRecord
{
  
	public $sum_price;
    public $sum_count;

    public static function tableName()
    {
        return 'shop_adres';
    }


	
	public function attributeLabels()
	{
		return 
		[
			 'name' => Yii::t('admin', 'ФИО'),
			 'phone' => Yii::t('admin', 'Телефон'),
			 'country' => Yii::t('admin', 'Страна'),
			 'oblast' => Yii::t('admin', 'Область'),
			 'street' => Yii::t('admin', 'Улица'),
             'house' => Yii::t('admin', 'Дом'),
 			 'flat' => Yii::t('admin', 'Квартира'),
             'post_index' => Yii::t('admin', 'Индекс'),
			'isselect'=>'isselect',
		];
	}
	
	 
	public function rules()
    {
		 
        return [
            
			[['count', 'price' ], 'default',  'on' => ['search'] ],
            [['street','phone','name','country','oblast','house'], 'required' ],
			['userid','default','value'=>yii::$app->user->getId() ],
            [['flat','post_index','isselect'], 'default' ],

        ];
    }
	 
    public function getItem()
    {
        return $this->hasOne(\app\modules\catalog\models\Catalog::className(), ['catalog_id' => 'itemid']);
    }


	public function search($params)
	{


		$query = self::find();

		$dataProvider = new ActiveDataProvider([
				'query' => $query,
				'pagination' => array('pageSize' => 50),
		]);


$query->andWhere(' userid = '.yii::$app->user->getId() );

		if (!($this->load($params) && $this->validate()) ) {
			return $dataProvider;
		}





		return $dataProvider;
	}


}