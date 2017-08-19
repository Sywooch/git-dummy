<?php

namespace app\modules\staticpage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \app\components\ActiveRecord as AR;

class Staticpage extends AR
{
  
	
    public static function tableName()
    {
        return 'static_page';
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
					'updatedAtAttribute' => 'static_page_date',
					'createdAtAttribute' => 'static_page_date',
					'value' => function(){ return date("Y-m-d H:i",strtotime($this->static_page_date)); } ,
					],
					 
					 [
					'class' => 'app\components\behaviors\PluploadAddFiles',
					'in_attribute' => self::tableName().'_id',
					],
          [
              'class' => 'app\components\behaviors\Language',
              'table' => 'static_page',
              'index' => 'static_page_id',
          ],
	
					
        ];
    }
	
 
	
	public function attributeLabels()
	{
		return 
		[
			 'static_page_id' => Yii::t('admin', 'Номер'),
			 'static_page_name' => Yii::t('admin', 'Название'),
			 'static_page_text' => Yii::t('admin', 'Описание'),
			 'static_page_date' => Yii::t('admin', 'Дата'),
			 
 			 'static_page_title' => Yii::t('admin', 'Название страницы'),
			 'static_page_url'  => Yii::t('admin', 'Адрес страницы'),
			 'static_page_meta' => Yii::t('admin', 'Описание страницы'),
			 'static_page_keys' => Yii::t('admin', 'Ключевый слова страницы'),
			
		];
	}
	


	   public function rules()
    {
        $rules=		 [
            [['static_page_name', 'static_page_url'], 'required', 'on' => ['default'] ],

            [['static_page_date'], 'default', 'value'=>new Expression('NOW()')],
                     /* ['static_page_date', 'match', 'pattern' => '/^[0-9]{2}-[0-9]{2}-[0-9]{4} [0-9]{2}:[0-9]{2}$/i'],*/

            [['static_page_title', 'static_page_date', 'static_page_meta','static_page_keys','static_page_text'], 'default'],

            [['static_page_meta','static_page_keys','static_page_text'], 'default', 'value'=>''],
            [['langid','lang'], 'default'],
            [['langid'], 'default','value'=>0],
        ];


            $rules[]=['static_page_url',  'match', 'pattern' => '/^\/[a-z0-9\-\_\/]+\.html$/i'];

        return $rules;
    }
	 
 public function getText($id)
 {
     $row = Staticpage::find();
     if(intval($id)==0){
         $row->andWhere('static_page_url = "'.$id.'" ');
     }else{
         $row->andWhere('static_page_id = "'.$id.'" or langid="'.$id.'" ');
     }
    $row= $row->one();

     return $row->static_page_text;
 }

	public function search($params)
    {

        $query = Staticpage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        $query->andFilterWhere(['static_page_id' => $this->static_page_id, ]);
		
        $query->andFilterWhere(['like', 'static_page_name', $this->static_page_name])
          	  ->andFilterWhere(['like', 'static_page_url', $this->static_page_url]);

        return $dataProvider;
    }
	
	
	/*public function afterFind(){
        if (parent::afterFind())
        {
			exit;
             $this->static_page_date = '11-11-2011';//Yii::$app->formatter->asDate($this->static_page_date)
            return true;
        }
        return false;
    }*/
	 
}