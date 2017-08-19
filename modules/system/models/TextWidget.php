<?php

namespace app\modules\system\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \app\components\ActiveRecord as AR;

class TextWidget extends  AR
{

    public static $status = [
        '1'=>'Кубок',
        '2'=>'Огонек',
        '4'=>'Синий',
        '3'=>'Желтый',
    ];
    public static $queryStatusOrder=' FIELD( `status`, 1, 2, 3,4,0) ';

    public static function tableName()
    {
        return 'widget_text';
    }
	 
	   
 
	public function getStatus($id=0){
        if($id)
            return self::$status[$id];
        return self::$status;
    }

	public function attributeLabels()
	{
		return 
		[
			 'id' => Yii::t('admin', 'Номер'),
			 'alias' => Yii::t('admin', 'Alias'),
			 'title' => Yii::t('admin', 'Название'),
			 'body' => Yii::t('admin', 'Описание'),
			 'statusid' => Yii::t('admin', 'Статус'),
			  
		];
	}

    public function behaviors()
    {
        return [
            [
                'class' => 'app\components\behaviors\Language',
                'table' => 'widget_text',
                'index' => 'widget_text_id',
                'fields' =>['statusid' ]
            ],

        ];
    }
	
	 
	   public function rules()
    {
		 
        return [
            
			[['title', 'alias' ], 'default',  'on' => ['search'] ],
			
			[['title', 'alias'], 'required', 'on' => ['default'] ],
			 
            [['title', 'alias', 'body','statusid'], 'default', 'value'=>''],

            [['langid','lang'], 'default'],
            [['langid'], 'default','value'=>0],
			 
            
        ];
    }
	 
  
    public static function getText($alias,$like='')
	{
	
	if($like)	
		return  TextWidget::find()->andWhere(['like','alias', $alias]  )->all();
	else	
		return  TextWidget::find()->andWhere([ 'alias' =>$alias ] )->all();
		
	}

    public static function get($alias,$lang=''){
        if($lang!='' )
            return TextWidget::find()->where([ 'alias' =>$alias,'lang'=>($lang=='ru')?NULL:$lang  ] );
            else
        return TextWidget::find()->andWhere([ 'alias' =>$alias  ] );
    }

	public function search($params)
    {

		
        $query = TextWidget::find();

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



        $query->andFilterWhere(['id' => $this->id, ])	;
		
		
        $query->andFilterWhere(['like', 'title', $this->title])
          	  ->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }

    public static function getTpl($alias,$tpls=[],$lang=''){

        $text = self::get($alias,$lang)->one();

        if(isset(yii::$app->user->identity->username))
            $tpls['username']=yii::$app->user->identity->username;

        foreach($tpls as $tpl=>$val) {
            if($tpl && $val && $text->body)
                  $text->body = str_replace('{' . $tpl . '}', $val, $text->body);
        }



        return $text->body;
    }
	
	 
	 
}