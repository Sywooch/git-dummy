<?php

namespace app\modules\menu\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use \app\components\ActiveRecord as AR;

class Menu extends AR
{

    public static function tableName()
    {
        return 'menu';
    }
     
	   public function behaviors()
    {
      return [
          [
              'class' => 'app\components\behaviors\Language',
              'table' => 'menu',
              'index' => 'menu_id',
			  'fields' =>['menu_url']
          ],
          [
					'class' => TimestampBehavior::className(),
					'updatedAtAttribute' => 'menu_url',
					'createdAtAttribute' => 'menu_url',
					'value' => function(){ 
						if($this->tableid && $this->tablename)
						{
							$query = new yii\db\Query;
							$query->createCommand()->update( $this->tablename,
											[
												$this->tablename.'_url' => $this->menu_url, 
												$this->tablename.'_name' => $this->menu_text, 
											],
											[
											$this->tablename.'_id' => $this->tableid
											] 
											)->execute ();
								 	
						}
						 
								return $this->menu_url; 
						} ,
					] 
        ];
    }
	
	
	public function attributeLabels()
	{
		return 
		[
			'menu_text' => Yii::t('admin', 'Название'),
			'menu_url' =>  Yii::t('admin', 'Адрес'),
			'menu_parentid' => '',
			'alias' =>  Yii::t('admin', 'Alias'),

			
		];
	}
	
	 
	   public function rules()
    {
		 
        return [
            
			
			[['menu_text',   'menu_url', 'alias'], 'required'],
			 
		    [['menu_parentid','tableid'], 'default', 'value' => 0],
			[['tablename'], 'default', 'value' => ''],

            [['langid','lang'], 'default'],
            [['langid'], 'default','value'=>0],
            
        ];
    }
	 
 
	  
	
	 
}