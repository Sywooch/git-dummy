<?php

namespace app\modules\shop\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Shop extends \yii\db\ActiveRecord
{
  
	public static $pay = [
        1=>'Пластиковая карта',
        2=>'Почтовый перевод',
        3=>'Банковский перевод',
        4=>'Наложенный платеж',
    ];

    public static $discount = [
        2=>2,
        3=>3,
        4=>4,
        5=>5,
        6=>6,
        7=>15
    ];

    public static function getDiscount($num)
    {
        if(in_array($num,Shop::$discount))
            return Shop::$discount[$num];
        else
            if($num>7)
                return 15;

        return 100;
    }
    public static function tableName()
    {
        return 'shop';
    }


 
	
	public function attributeLabels()
	{
		return 
		[
			 'shop_id' => Yii::t('admin', 'Номер'),

			 'fio' => Yii::t('app', 'Ваше имя'),
			 'email' => Yii::t('app', 'Email'),
			 'phone' => Yii::t('app', 'Телефон'),

             'country' => Yii::t('app', 'Местоположение'),
             'obl' => Yii::t('admin', 'Область'),
             'town' => Yii::t('app', 'Город'),

             'index' => Yii::t('app', 'Почтовый индекс'),
             'adres' => Yii::t('app', 'Адрес доставки'),
             'shoppayid' => Yii::t('admin', 'Способ доставки'),

			 'shop_date' => Yii::t('admin', 'Дата'),
			 
 			 'shopcatid' => Yii::t('admin', 'Статус'),
            'payed' => Yii::t('admin', 'Оплачено'),

			
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
            [['fio' ,'email','phone','adres','country','index' ], 'required' , 'on' => ['default'] ],
            [['fio','shoppayid','adres','obl','town', 'country','email','index','phone','shopcatid','shop_id' ], 'default',  'on' => ['search'] ],
            [['payed','fio','shoppayid','adres','obl','town', 'country','email','index','phone','shopcatid','shop_id','delivery','delivery_price','message' ], 'default',   ],
           // ['index', 'match', 'pattern' => '/^[0-9]{6}$/i', 'on' => ['default']],
            ['phone', 'match', 'pattern' => '/^[0-9 \-\+]+$/i', 'on' => ['default']],
            ['index', 'match', 'pattern' => '/^[0-9]+$/i', 'on' => ['default']],
            [[ 'email' ], 'email' ],
			[['shop_date'], 'default', 'value'=>new Expression('NOW()')],
			[['shopcatid'], 'default', 'value'=>1],
            [['isread'], 'default', 'value'=>0],
            [['userid'], 'default', 'value'=>((yii::$app->user->id)?yii::$app->user->id:0) ],

        ];
    }

    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'userid']);
    }
  public function getStatus()
    {

        $item=\app\modules\terms\models\Terms::find()->andWhere(['terms_id'=>$this->shopcatid])->one();
        if($item)
            return $item;
        else
            return \app\modules\terms\models\Terms::find()->andWhere(['langid'=>$this->shopcatid])->one();

    }
    public function getItems()
    {
        return $this->hasMany(\app\modules\shop\models\ShopItem::className(), ['shopid' => 'shop_id']);
    }
    public function getPrice()
    {
        return $this->hasOne(\app\modules\shop\models\ShopItem::className(), ['shopid' => 'shop_id'])
            ->select('sum(count*price) as sum_price')             ;
    }
    public function getCount()
    {
        return $this->hasOne(\app\modules\shop\models\ShopItem::className(), ['shopid' => 'shop_id'])
            ->select('sum(count) as sum_count')             ;
    }

	public function search($params)
    {

		
        $query = Shop::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => array('pageSize' => 50),
        ]);


        $query->andFilterWhere(['payed' => 1 ])	;
 	 
		if (!( $this->validate()) ) {
		   var_dump($this->getErrors());
        }
 
        if (!($this->load($params) && $this->validate()) ) {
           return $dataProvider;
        }



        $query->andFilterWhere(['shop_id' => $this->shop_id, ])	;
		
		if( !empty($this->shopcatid) )
		$query->andFilterWhere(['shopcatid' => $this->shopcatid, ])	;
		
        $query->andFilterWhere(['like', 'fio', $this->fio])
          	  ->andFilterWhere(['like', 'email', $this->email])
              ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }


    public static function getDeliveryPrice(){
        $price = 15;
        if(\yii::$app->user->getID()){

            switch(\yii::$app->user->identity->utype){
                case '1':$price=0;break;
                case '2':$price=0;break;
                case '3':$price=15;break;
                case '4':$price=10;break;
            }
        }
        return $price;
    }
    public static function delivery($weight){

        $controlWeight=1;

        return $weight*self::getDeliveryPrice();
    }
	
	 
	 
}