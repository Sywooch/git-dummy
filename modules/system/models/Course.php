<?php

namespace app\modules\system\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \app\components\ActiveRecord as AR;

class Course extends  ActiveRecord
{




    public static function tableName()
    {
        return 'course';
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
	 
  


    public static function get($alias){
        return Course::find()->andWhere([ 'alias' =>$alias  ] )->one();
    }


    public static function getPriceClear($price,$after=0){
        $alias=self::getCurrency();
        $course=self::get($alias);
        $price=$course->price * $price;

        if($course->format1==0 && $price %1 == 0){
            $price =  number_format( $price,($after)?$after:$course->format1,$course->format2,$course->format3);
        }else{
            $price= number_format(  $price,($after)?$after:$course->format1,$course->format2,$course->format3);
            $price = self::number_format_clean(
                $price,
                0,$course->format2,$course->format3);
        }



        return str_replace(' ','',$price);
    }

    public static function getPrice($price,$after=0){
        $alias=self::getCurrency();
        $course=self::get($alias);
        $price=$course->price * $price;

        if($course->format1==0 && $price %1 == 0){
            $price =  number_format( $price,($after)?$after:$course->format1,$course->format2,$course->format3);
        }else{
             $price= number_format(  $price,($after)?$after:$course->format1,$course->format2,$course->format3);
            $price = self::number_format_clean(
                $price,
                0,$course->format2,$course->format3);
        }



        return $course->name.$price;
    }



    public static function getPriceCourse($price,$alias=''){
        $course=self::get($alias);
        $price=$course->price * $price;

        if($course->format1==0 && $price %1 == 0){
            $price =  number_format( $price,$course->format1,$course->format2,$course->format3);
        }else{
            $price= number_format(  $price,$course->format1,$course->format2,$course->format3);
            $price = self::number_format_clean(
                $price,
                0,$course->format2,$course->format3);
        }



        return $course->name.$price;
    }

    public static function number_format_clean($number,$precision=0,$dec_point=',',$thousands_sep=',')
    {
        return rtrim(rtrim($number,'0'),$dec_point);
    }

    public static function getCurrency()
    {
        /*if(\yii::$app->request->get('curs'))
       return  \yii::$app->request->get('curs','USD');*/
        return \Yii::$app->session->get('currency','USD');
    }


    public static function getDefaultPrice($price)
    {
        $alias=self::getCurrency();
        $course=self::get($alias);

        return $price/$course->price;
    }

    public static function getName()
    {
        $alias=self::getCurrency();
        $course=self::get($alias);
        return  $course->name;
    }

    public static function getMoney()
    {
        $alias=self::getCurrency();
        $course=self::get($alias);
        return  $course->price;
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