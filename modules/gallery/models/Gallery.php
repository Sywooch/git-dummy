<?php

namespace app\modules\gallery\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Gallery extends \yii\db\ActiveRecord
{
  
	
    public static function tableName()
    {
        return 'gallery';
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
					'updatedAtAttribute' => 'date_modified',
					'createdAtAttribute' => 'date_modified',
					'value' => new Expression('NOW()'),
					],
					[
					'class' => TimestampBehavior::className(),
					'updatedAtAttribute' => 'gallery_date',
					'createdAtAttribute' => 'gallery_date',
					'value' => function(){ return date("Y-m-d H:i",strtotime($this->gallery_date)); } ,
					],
					 
					 [
					'class' => 'app\components\behaviors\PluploadAddFiles',
					'in_attribute' => self::tableName().'_id',
					]
	
					
        ];
    }
	
 
	
	public function attributeLabels()
	{
		return 
		[
			 'gallery_id' => Yii::t('admin', 'Номер'),
			 'gallery_name' => Yii::t('admin', 'Название'),
			 'gallery_text' => Yii::t('admin', 'Описание'),
			 'gallery_url' => Yii::t('admin', 'Ссылка'),
			 'gallery_date' => Yii::t('admin', 'Дата'),
			 'gallerycatid' => Yii::t('admin', 'Категория'),
             'lang' => Yii::t('admin', 'Язык'),
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
            
			#[['seo_title', 'seo_url'], 'default',  'on' => ['search'] ],
			
			[['gallery_name','lang'], 'required', 'on' => ['default'] ],
			
			#[['gallery_date'], 'default', 'value'=>new Expression('NOW()')],
			#['gallery_date', 'match', 'pattern' => '/^[0-9]{2}-[0-9]{2}-[0-9]{4} [0-9]{2}:[0-9]{2}$/i'],
				
			[[ 'gallery_text','gallery_url','gallerycatid'], 'default'],
           
            [['gallery_text','gallery_url'], 'default', 'value'=>''],
			[['gallerycatid'], 'default', 'value'=>'0'],
        ];
    }
	 
 

	public function search($params)
    {

        $query = Gallery::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['gallery_id' => $this->gallery_id, ]);
		
        $query->andFilterWhere(['like', 'gallery_name', $this->gallery_name])  	  ;

        return $dataProvider;
    }
	
	
	/*public function afterFind(){
        if (parent::afterFind())
        {
			exit;
             $this->gallery_date = '11-11-2011';//Yii::$app->formatter->asDate($this->gallery_date)
            return true;
        }
        return false;
    }*/
	 
}