<?php

namespace app\modules\terms\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Terms_cat extends \yii\db\ActiveRecord
{


    public static function tableName(){
        return 'terms_cat';
    }


    public function behaviors()
    {
        return [
            [
                'class' => 'app\components\behaviors\Language',
                'table' => 'terms_cat',
                'index' => 'terms_cat_id',
            ],
        ];
    }

	public function attributeLabels()
	{
		return 
		[
			'terms_cat_text' => Yii::t('admin', 'Название'),
			
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
            
			[['terms_cat_text'], 'required'],
            [['langid','lang'], 'default'],
            [['langid'], 'default','value'=>0],

        ];
    }
	
	
	static function dropDown()
	{
		$data =	Terms_cat::find()->all()	;
		if(is_array($data))
		{
			foreach($data as $row)
			{
				$out[$row->terms_cat_id]=$offset.$row->terms_cat_text;	
			}
		}
		return $out;
	}
 
 
 public static function getbyId($id)
	{
		$data =	Terms_cat::find()->where(['terms_cat_id' => $id ])->one()	;
		return $data;
	}



	 
}