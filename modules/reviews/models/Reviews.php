<?php

namespace app\modules\reviews\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Reviews extends \yii\db\ActiveRecord
{
  
	
    public static function tableName()
    {
        return 'reviews';
    }
	public static function urlPrefix()
    {
        return '/';
    }
	
	  public function behaviors()
    {
      return [

					[
					'class' => TimestampBehavior::className(),
					'updatedAtAttribute' => 'reviews_date',
					'createdAtAttribute' => 'reviews_date',
					//'value' => function(){ return date("Y-m-d H:i",strtotime($this->reviews_date)); } ,
					] 
					
        ];
    }
	
 
	
	public function attributeLabels()
	{
		return 
		[
			 'reviews_id' => Yii::t('admin', 'Номер'),

			 'reviews_text' => Yii::t('admin', 'Отзыв'),
			 'tablename' => Yii::t('admin', ''),
             'tableid' => Yii::t('admin', ''),
			 'reviews_date' => Yii::t('admin', 'Дата'),
			 'userid' => Yii::t('admin', 'Пользователь'),
             'reviews_public' => Yii::t('admin', 'Опубликовано'),
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
            
			#[['seo_title', 'seo_url'], 'default',  'on' => ['search'] ],
			
			[['reviews_text','tableid','tableid'], 'required', 'on' => ['default'] ],
			
			[['reviews_date'], 'default', 'value'=>new Expression('NOW()')],
			#['reviews_date', 'match', 'pattern' => '/^[0-9]{2}-[0-9]{2}-[0-9]{4} [0-9]{2}:[0-9]{2}$/i'],
				
			[[ 'userid','reviews_public'], 'default'],

        ];
    }
	 
 

	public function search($params)
    {

        $query = Reviews::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['reviews_id' => $this->reviews_id, ]);
		
        $query->andFilterWhere(['like', 'reviews_text', $this->reviews_text])  	  ;

        return $dataProvider;
    }
	
	
	/*public function afterFind(){
        if (parent::afterFind())
        {
			exit;
             $this->reviews_date = '11-11-2011';//Yii::$app->formatter->asDate($this->reviews_date)
            return true;
        }
        return false;
    }*/
	 
}