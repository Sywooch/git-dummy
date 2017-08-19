<?php

 
 

namespace app\modules\system\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;


class Pictures extends \yii\db\ActiveRecord
{
  	
	 const EXT='jpg';
	 const QUALITY='70';

	 public static function tableName()
    {
        return 'image';
    }
	  public function behaviors()
    {
      return [
					[
					'class' => TimestampBehavior::className(),
					'updatedAtAttribute' => 'created',
					'createdAtAttribute' => 'created',
					'value' => new Expression('NOW()'),
					],
        ];
    }
	
	
	 public function attributeLabels()
	{
		return 
		[
					
			'extension' =>   Yii::t('admin', 'Расширение'),			
			'filename'  => 	 Yii::t('admin', 'Название'),
			'byteSize'  => 	 Yii::t('admin', 'Размер'),			
			'mimeType'  =>   Yii::t('admin', 'Mime'),
			'name'      =>   Yii::t('admin', 'Модель'),	
			'tableid'   =>   Yii::t('admin', 'Запись'),
			'order'     =>   Yii::t('admin', 'Очередность'),			
			'NotActive' =>   Yii::t('admin', 'Используется'),
			'alt' =>   Yii::t('admin', 'alt'),
			'title' =>   Yii::t('admin', 'title'),
		
		];
	}
	
	
	   public function rules()
    {
		 
        return [
            
			 
			[['extension', 'filename', 'byteSize','mimeType','name','tableid','order','NotActive','alt','title'], 'default'],
           
            
        ];
    }
	   
	   
	   public static function getImages($tableName, $id)
	   {
		
		$data = (new \yii\db\Query())->from('image')->where([ 'name' => $tableName , 'tableid' => $id ])->orderBy('order')->all();
		
		return $data;   
	   }

    public static function getImagesSlider($tableName, $id)
    {

        $data = (new \yii\db\Query())->from('image')->where([ 'name' => $tableName , 'tableid' => $id,'isslider'=>1 ])->orderBy('order')->all();

        return $data;
    }
	 
  
	 
}