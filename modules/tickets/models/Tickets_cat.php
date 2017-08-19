<?php

namespace app\modules\tickets\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Tickets_cat extends \yii\db\ActiveRecord
{
  
	
    public static function tableName()
    {
        return 'tickets_cat';
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

					
        ];
    }
	
 
	
	public function attributeLabels()
	{
		return 
		[
			 'id' => Yii::t('admin', 'Номер'),
			 'title' => Yii::t('admin', 'Название'),
			 'userid' => Yii::t('admin', 'Автор'),
			 'date_modified' => Yii::t('admin', 'Дата'),
			 
 			 'statusid' => Yii::t('admin', 'Статус'),

			
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
			[['title', /*'userid','statusid'*/], 'required'  ],
            [['userid'],'default', 'value'=>yii::$app->user->getId()],
            [['statusid'],'default','value'=>117],
        ];
    }
    public function getMes()
    {
        return $this->hasMany(\app\modules\tickets\models\Tickets::className(), ['tcatid' => 'id'])->orderBy('date_modified DESC');
    }

    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'userid']);
    }

    public function getTerms()
    {
        return $this->hasOne(\app\modules\terms\models\Terms::className(), ['terms_id' => 'statusid']);
    }

	public function search($params)
    {

        $query = Tickets_cat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function searchFront($params)
    {

        $query = Tickets_cat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere('userid = '.yii::$app->user->getId()  );
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

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