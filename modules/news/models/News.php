<?php

namespace app\modules\news\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \app\components\ActiveRecord as AR;

class News extends AR
{
  
	
    public static function tableName()
    {
        return 'news';
    }
	public static function urlPrefix()
    {
        return '/news/';
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
					'updatedAtAttribute' => 'news_date',
					'createdAtAttribute' => 'news_date',
					'value' => function(){ return date("Y-m-d H:i",strtotime($this->news_date)); } ,
					],
					 
					 [
					'class' => 'app\components\behaviors\PluploadAddFiles',
					'in_attribute' => self::tableName().'_id',
					],
          [
              'class' => 'app\components\behaviors\Language',
              'table' => 'news',
              'index' => 'news_id',
			  'fields' =>['news_url','news_date','newscatid' ]
          ],
	
					
        ];
    }
	
 
	
	public function attributeLabels()
	{
		return 
		[
			 'news_id' => Yii::t('admin', 'Номер'),
			 'news_name' => Yii::t('admin', 'Название'),
			 'news_text' => Yii::t('admin', 'Описание'),
			 'news_preview' => Yii::t('admin', 'Краткое описание'),
			 'news_date' => Yii::t('admin', 'Дата'),
			 
 			 'news_title' => Yii::t('admin', 'Название страницы'),
			 'news_url'  => Yii::t('admin', 'Адрес страницы'),
			 'news_meta' => Yii::t('admin', 'Описание страницы'),
			 'news_keys' => Yii::t('admin', 'Ключевый слова страницы'),
			 
			 'newscatid' => Yii::t('admin', 'Раздел'),
			
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
            
			[['news_name', 'news_url' ], 'default',  'on' => ['search'] ],
			
			[['news_name', 'news_url','newscatid'], 'required', 'on' => ['default'] ],
			
			[['news_date'], 'default', 'value'=>new Expression('NOW()')],
			
			['news_url',  'match', 'pattern' => '/^\/news\/[a-z0-9\-\_]+\.html$/i', 'on' => ['default'],
				'message'=>Yii::t('admin', 'Адрес должен быть "/news/sometext.html"' ), ],
			
			//['news_date', 'match', 'pattern' => '/^[0-9]{2}-[0-9]{2}-[0-9]{4} [0-9]{2}:[0-9]{2}$/i', 'on' => ['default']],
				
			[['news_title', 'news_date', 'news_meta','news_keys','news_text','news_preview'], 'default'],
            [['news_title', 'news_date', 'news_meta','news_keys','news_text','news_preview','newscatid'], 'default', 'value'=>''],
		#	[['newscatid'], 'default', 'value'=>0],
		#	[['newscatid'], 'exist', 'targetClass'=>\app\modules\terms\models\Terms::className(), 'targetAttribute'=>'terms_id'],
            [['langid','lang'], 'default'],
            [['langid'], 'default','value'=>0],
            
        ];
    }
	 
  public function getTerms()
    {
        return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'newscatid']);
    }

	public function search($params)
    {

		
        $query = News::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => array('pageSize' => 50),
        ]);



 	 
		if (!( $this->validate()) ) {
		   var_dump($this->getErrors());
        }
 
        if (!($this->load($params) && $this->validate()) ) {
           return $dataProvider;
        }



        $query->andFilterWhere(['news_id' => $this->news_id, ])	;
		
		if( !empty($this->newscatid) )
		$query->andFilterWhere(['newscatid' => $this->catalogcatid, ])	;
		
        $query->andFilterWhere(['like', 'news_name', $this->news_name])
          	  ->andFilterWhere(['like', 'news_url', $this->news_url]);

        return $dataProvider;
    }
	
	
	 
	 
}