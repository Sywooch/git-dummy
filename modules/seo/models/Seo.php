<?php

namespace app\modules\seo\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Seo extends \yii\db\ActiveRecord
{
  
	public static function tableName()
	{
			return 'seo';
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
        ];
    }
	
	
	public function attributeLabels()
	{
		return 
		[
			'seo_title' => 'TITLE',
			'seo_url' => Yii::t('admin', 'Адрес страницы'),
			
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
            
			[['seo_title', 'seo_url'], 'default',  'on' => ['search'] ],
			
			[['seo_title', 'seo_url'], 'required', 'on' => ['default'] ],
			
			[['seo_keys', 'seo_meta', 'seo_text','seo_page'], 'default'],
           
            
        ];
    }
	 
   public static function makeHead($row)
   {
	
 
 
	if( !$row )
	{
		$row = Seo::find()->where(['seo_url' => '/'.Yii::$app->getRequest()->pathInfo ])->one();
	}



	 $table = $row->tableName();



	Yii::$app->params['title']    = $row[$table.'_title'];
	Yii::$app->params['meta']     = $row[$table.'_meta'];
	Yii::$app->params['keys']     = $row[$table.'_keys'];
	Yii::$app->params['modified'] = $row['date_modified'];
	
	if( isset($_GET['page']) && !empty($_GET['page']) )
	{

		#if(preg_match("/\/".$row['prefix']."\/([0-9a-zA-Z\-]+)/i", $_SERVER['REQUEST_URI'])) {
		 Yii::$app->params['canonical'] =  '<link rel="canonical" href="'.'/'.Yii::$app->getRequest()->pathInfo.'/'.$row[$table.'_url'].'"/>';
		 

	}else{
	
	Yii::$app->params['canonical'] = '';
		
	}
	   
   }

	public function search($params)
    {

        $query = Seo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['seo_id' => $this->seo_id, ]);
		
        $query->andFilterWhere(['like', 'seo_title', $this->seo_title])
          	  ->andFilterWhere(['like', 'seo_url', $this->seo_url]);

        return $dataProvider;
    }
	
	 
}