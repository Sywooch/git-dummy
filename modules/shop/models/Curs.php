<?php

namespace app\modules\shop\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \app\components\ActiveRecord as AR;

class Curs extends  ActiveRecord
{

    public $active='';
    public $default='';


    public static function tableName()
    {
        return 'shop_currency';
    }
	 
	   

	public function attributeLabels()
	{
		return 
		[
			 'id' => Yii::t('admin', 'Номер'),
			 'alias' => Yii::t('admin', 'Alias'),
			 'name' => Yii::t('admin', 'Как отображается'),
			 'price' => Yii::t('admin', 'Курс относительно $'),
             'format1' => Yii::t('admin', 'знаков после запятой'),
             'format2' => Yii::t('admin', 'разделение сотых'),
             'format3' => Yii::t('admin', 'разделение между тысячами'),

            /*number_format( $myNumber, знаков после запятой, 'разделение сотых', ' разделение между тысячами' );*/
		];
	}


	
	 
	   public function rules()
    {
		 
        return [
            
			[['alias', 'name','price' ], 'required'],
            [['persent','format1', 'format2','format3'], 'default'],

        ];
    }
	 
  


    public  function get($alias){
        return Curs::find()->andWhere([ 'alias' =>$alias  ] )->one();
    }


    public  function getPrice($price,$after=0){

        $alias=$this->getCurrency();

        if(!$this->active)
            $this->active=$this->get($alias);

        $price=$this->active->price * $price;

        if($this->active->format1==0 && $price %1 == 0){
            $price =  number_format( $price,($after)?$after:$this->active->format1,$this->active->format2,$this->active->format3);
        }else{
             $price= number_format(  $price,($after)?$after:$this->active->format1,$this->active->format2,$this->active->format3);
            $price = self::number_format_clean(
                $price,
                0,$this->active->format2,$this->active->format3);
        }
        return $price.' '.$this->active->name;
    }

    public static function number_format_clean($number,$precision=0,$dec_point=',',$thousands_sep=',')
    {
        return rtrim(rtrim($number,'0'),$dec_point);
    }

    public   function getCurrency()
    {
        /*if(\yii::$app->request->get('curs'))
       return  \yii::$app->request->get('curs','USD');*/
        return \Yii::$app->session->get('currency',$this->default);
    }

    public  function getName()
    {

        if(!$this->active) {
            $alias=self::getCurrency();
            $this->active = $this->get($alias);
        }
        return  $this->active->name;
    }

    public  function getCurs()
    {

        if(!$this->active) {
            $alias=self::getCurrency();
            $this->active = $this->get($alias);
        }
        return  $this->active->price;
    }

    public function search($params)
    {


        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => array('pageSize' => 50),
        ]);




        if (!($this->load($params) && $this->validate()) ) {
            return $dataProvider;
        }





        return $dataProvider;
    }



}